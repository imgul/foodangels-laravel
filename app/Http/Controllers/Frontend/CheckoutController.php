<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\UserRole;
use App\Models\DeliveryAddress;
use App\Models\RestaurantPostalCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Paystack;

use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Address;
use App\Models\Restaurant;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Services\StripeService;
use Illuminate\Support\Facades\Http;
use App\Http\Services\PaymentService;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\FrontendController;
use App\Http\Services\PushNotificationService;
use Spatie\Permission\Models\Role;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;
use Illuminate\Support\Facades\Log;
use Exception;

class CheckoutController extends FrontendController
{
    protected User|null $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Checkout';

        if (auth()->check()) {
            $this->user = auth()->user();
        }
    }

    public function index()
    {
        if (blank(session()->get('cart'))) {
            return redirect('/');
        }

        if (auth()->check()) {
            $this->user = auth()->user();
        }

        $this->data['is_auth'] = false;
        $this->data['user'] = $this->user;
        $this->data['addresses'] = [];
        $this->data['lastAddress'] = [];

        if ($this->user) {
            $this->data['is_auth'] = true;

//            $this->data['addresses'] = Address::where('user_id', $this->user->id)->get();
//            $this->data['lastAddress'] = '';
            $this->data['delivery_address'] = DeliveryAddress::where('user_id', $this->user->id)->first();
//            dd( $this->data['delivery_address']);

//            $lastAddress = Order::select('address')->where('user_id', $this->user->id)->latest()->first();
//            if (!blank($lastAddress)) {
//                if (isJson($lastAddress->address)) {
//                    $this->data['lastAddress'] = Address::where('address', json_decode($lastAddress->address, true)['address'])->first();
//                }
//            }
//
//            if (blank($this->data['lastAddress'])) {
//                $this->data['lastAddress'] = Address::where('user_id', $this->user->id)->first();
//            }
        }

        $this->data['menuitems']    = session()->get('cart');
        $this->data['totalPayment'] = session()->get('cart')['totalPayAmount'];
        $this->data['restaurant']   = Restaurant::find(session('session_cart_restaurant_id'));
        return view('frontend.restaurant.checkout', $this->data);
    }

    public function checkPostal(Request $request)
    {
        $sessionRestaurantId = session('session_cart_restaurant_id');
        $postCode = $request->postCode;

        $RestaurantPostalCode = RestaurantPostalCode::where(['postal_code' => $postCode, 'restaurant_id' => $sessionRestaurantId])->first();
        if ($RestaurantPostalCode) {
            $delivery_charge = $RestaurantPostalCode->delivery_charge;
            $delivery_time = $RestaurantPostalCode->delivery_time;
            $min_order = $RestaurantPostalCode->min_order;
            $max_order = $RestaurantPostalCode->max_order;
            $carts = session()->get('cart');
            $totalAmount = $carts['totalAmount'];
            $totalPayAmount = $carts['totalPayAmount'];
            if ($totalAmount > $min_order && $totalAmount < $max_order) {
                $carts['delivery_charge'] = $delivery_charge;
                $newtotalPayAmount = $carts['totalAmount'] + $delivery_charge;
                $carts['totalPayAmount'] = $newtotalPayAmount;
                echo json_encode(array('status' => 'success', 'msg' => '', 'subtotal' => currencyName(number_format($totalAmount, 2)), 'delivery' => currencyName(number_format($delivery_charge, 2)), 'total' => currencyName(number_format($newtotalPayAmount, 2)), 'msg_for' => 'delivery'));
            } elseif ($totalAmount > $max_order) {
                $carts['delivery_charge'] = 0;
                $carts['free_delivery'] = 1;
                $carts['totalPayAmount'] = $totalAmount;
                echo json_encode(array('status' => 'success', 'msg' => '', 'subtotal' => currencyName(number_format($totalAmount, 2)), 'delivery' => 'free', 'total' => currencyName(number_format($totalAmount, 2)), 'msg_for' => 'delivery'));
            }
            session()->put('cart', $carts);
            if ($totalAmount < $min_order) {
                echo json_encode(array('status' => 'failed', 'msg' => 'Minimum order for this postal code is ' . currencyName(number_format($min_order, 2)) . '. Please increase your order value.', 'msg_for' => 'min_order'));
            }
        } else {
            echo json_encode(array('status' => 'failed', 'msg' => 'We not delivering to this address because of the area. Please contact via WhatsApp or telephone. Thanks', 'msg_for' => 'postcode'));
        }
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $this->user = null;
        if (auth()->check()) {
            $this->user = auth()->user();
        }

        $sessionRestaurantId = session('session_cart_restaurant_id');
        if (blank($sessionRestaurantId)) {
            return redirect(route('checkout.index'))->withError('The Restaurant not found');
        }

        $this->setDeliveryCharge($request);
        $restaurant = Restaurant::find($sessionRestaurantId);
        $validator = $this->validateCheckoutRequest($request, $restaurant);
        if ($this->user && !session()->get('cart')['delivery_type']) {
            $validation = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'mobile'       => 'required',
                'payment_type' => 'required|numeric',
            ];

            $validation['street_name'] = 'required|string';
            $validation['house_number'] = 'required|string';
            $validation['post_code'] = 'required|numeric|exists:restaurant_postal_codes,postal_code';
            $validation['city'] = 'nullable|string';
            $validation['floor'] = 'nullable|string';
            $validation['company_name'] = 'nullable|string';
            $validation['note'] = 'nullable|string';
        } else {
            $validation = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'mobile'       => 'required',
                'payment_type' => 'required|numeric',
            ];
        }

        $request->validate($validation);

        DB::beginTransaction();

        // create user if not exists
        if (!$this->user) {
            $user = $this->createUser($request);
            if (!blank($user)) {
                // auth()->login($user);
                session()->put('user_id', $user?->id);
                $this->user = $user;
            }
        }

        if ($this->user) {
            // get the first address of the user
            $address = DeliveryAddress::where('user_id', $this->user->id)->first();
            if (blank($address)) {
                // save delivery address
                $this->saveDeliveryAddress($request);
            } else {
                 // update delivery address
                $this->updateDeliveryAddress($request, $address);
            }
        }

        $validator = Validator::make($request->all(), $validation);
        if($this->user) {
            $validator->after(function ($validator) use ($request, $restaurant) {
                if ($request->payment_type === PaymentMethod::WALLET) {
                    if ((float)$this->user->balance->balance < (float)(session()->get('cart')['totalAmount'] + session()->get('delivery_charge'))) {
                        $validator->errors()->add('payment_type', 'The Credit balance does not enough for this payment.');
                    }
                }
            });
        }

        $validator->validate();

        if ($validator->fails()) {
            DB::rollBack();
            return redirect(route('checkout.index'))->withError($validator);
        }


        if (!$this->user) {
            DB::rollBack();
            return redirect()->route('login');
        }
        DB::commit();

        session()->put('checkoutRequest', $request->all());
        $paymentType = $request->payment_type;
        if ($paymentType == PaymentMethod::STRIPE) {
            return $this->processStripePayment($restaurant);
        } elseif ($paymentType == PaymentMethod::PAYSTACK) {
            return $this->preparePaystackPaymentData($request);
        } elseif ($paymentType == PaymentMethod::PAYTM) {
            return $this->payWithPaytm($request);
        } elseif ($paymentType == PaymentMethod::PHONEPE) {
            return $this->phonePePayment($request);
        } elseif ($paymentType == PaymentMethod::PAYPAL) {
            return $this->initiatePaypalPayment();
        } elseif ($paymentType == PaymentMethod::SSLCOMMERZ) {
            return $this->sslcommerzPayment($request);
        } elseif ($paymentType == PaymentMethod::RAZORPAY) {
            return $this->processRazorpayPayment($request);
        } else {
            return $this->processDefaultPayment();
        }
    }

    public function createUser($request)
    {
        // validate request
//        $validator = Validator::make($request->all(), [
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'email' => 'required|email',
//            'mobile' => 'required',
//        ]);
//        $validator->validate();
        $address = $request->street_name . ', ' . $request->house_number . ', ' . $request->post_code . ', ' . $request->city . ', ' . $request->floor;

        // Find user
        $this->user = User::where('email', $request->email)->first();
        if ($this->user) {
            // update user
            $this->user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->first_name,
                'phone' => $request->mobile,
                'address' => $address,
            ]);

            return $this->user;
        }


        $this->user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->first_name,
            'password' => bcrypt(123456),
            'phone' => $request->mobile,
            'address' => $address,
        ]);

        // assign the role to the user as customer
        $role = Role::find(UserRole::CUSTOMER);
        if (!blank($this->user) && !blank($role)) {
            $this->user->assignRole($role->name);
        }

        return $this->user;
    }

    public function saveDeliveryAddress($request)
    {
        $deliveryAddress = DeliveryAddress::create([
            'user_id' => $this->user->id,
            'street_name' => $request->street_name,
            'house_number' => $request->house_number,
            'postal_code' => $request->post_code,
            'city' => $request->city,
            'floor' => $request->floor,
            'company_name' => $request->company_name,
            'note' => $request->note,
        ]);

        return $deliveryAddress;
    }

    public function updateDeliveryAddress($request, $address)
    {
        $address->update([
            'street_name' => $request->street_name,
            'house_number' => $request->house_number,
            'postal_code' => $request->post_code,
            'city' => $request->city,
            'floor' => $request->floor,
            'company_name' => $request->company_name,
            'note' => $request->note,
        ]);

        return $address;
    }

    public function sslcommerzPayment($request)
    {
        try {
            $array['store_id']         = env('SSLCOMMERZ_STORE_ID');
            $array['store_passwd']     = env('SSLCOMMERZ_STORE_PASSWORD');
            $array['total_amount']     = session()->get('cart')['totalAmount'] + session()->get('delivery_charge');
            $array['currency']         = "USD";
            $array['tran_id']          = "SSLCZ_" . uniqid();
            $array['shipping_method']  = "NO";
            $array['cus_name']         = auth()->user()->name;
            $array['cus_email']        = auth()->user()->email;
            $array['cus_add1']         = $request->address;
            $array['cus_city']         = "";
            $array['cus_state']        = "";
            $array['cus_postcode']     = "";
            $array['cus_country']      = "";
            $array['cus_phone']        = $request->countrycode . $request->mobile;
            $array['product_name']     = "FoodBank";
            $array['product_category'] = "Food";
            $array['product_profile']  = "general";
            $array['product_amount']   = session()->get('cart')['totalAmount'] + session()->get('delivery_charge');
            $array['discount_amount']  = "";
            $array['convenience_fee']  = session()->get('delivery_charge');
            $array['success_url']      = url('/sslcommerz/success');
            $array['fail_url']         = url('/sslcommerz/fail');
            $array['cancel_url']       = url('/sslcommerz/cancel');

            $apiUrl                    = 'sandbox' == env('SSLCOMMERZ_MODE') ? "https://sandbox.sslcommerz.com/gwprocess/v4/api.php" : "https://securepay.sslcommerz.com/gwprocess/v4/api.php";

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $apiUrl);
            curl_setopt($handle, CURLOPT_TIMEOUT, 30);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $array);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, !('sandbox' == env('SSLCOMMERZ_MODE')));

            $content = curl_exec($handle);
            $code    = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            if ($code == 200 && !(curl_errno($handle))) {
                curl_close($handle);
                $sslcommerzResponse = $content;
            } else {
                curl_close($handle);
                return redirect(route('checkout.index'))->withError('Failed to connect with SSLCOMMERZ API');
            }

            $response = json_decode($sslcommerzResponse, true);

            if (isset($response['GatewayPageURL']) && $response['GatewayPageURL'] != "") {
                return redirect($response['GatewayPageURL']);
            } else {
                return redirect(route('checkout.index'))->withError('JSON Data parsing error!');
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return redirect(route('checkout.index'))->withError('Something went wrong!');
        }
    }

    public function sslcommerzSuccess(Request $request)
    {
        if (isset($request->bank_tran_id)) {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }
        return $this->handleOrderServiceResponse($orderService);
    }

    public function sslcommerzFail()
    {
        return redirect(route('checkout.index'))->withError('Something went wrong!');
    }
    public function sslcommerzCancle()
    {
        return redirect(route('checkout.index'))->withError('Something went wrong!');
    }

    public function phonePePayment($request)
    {
        $phonepe     = new LaravelPhonePe();
        $amount      = session()->get('cart')['totalAmount'] + session()->get('delivery_charge');
        $phone       = $request->countrycode . $request->mobile;
        $callbak_url = url('/phonepe/status');
        $uniqueId    = uniqid();
        $url         = $phonepe->makePayment($amount, $phone, $callbak_url, $uniqueId);
        return redirect()->away($url);
    }

    public function phonepeCallback(Request $request)
    {
        $phonepe      = new LaravelPhonePe();
        $response     = $phonepe->getTransactionStatus($request->all());
        if ($response) {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }
        return $this->handleOrderServiceResponse($orderService);
    }

    protected function payWithPaytm($request)
    {
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order'         => uniqid(),
            'user'          => auth()->user()->id,
            'mobile_number' => $request->countrycode . $request->mobile,
            'email'         => auth()->user()->email,
            'amount'        => session()->get('cart')['totalAmount'] + session()->get('delivery_charge'),
            'callback_url'  => url('/paytm/status'),
        ]);
        return $payment->receive();
    }

    protected function paytmCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response    = $transaction->response();
        if ($transaction->isSuccessful()) {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }
        return $this->handleOrderServiceResponse($orderService);
    }

    protected function setDeliveryCharge($request)
    {
        $deliveryCharge = $request->total_delivery_charge;
        session()->put('delivery_charge', $deliveryCharge ?: 0);
    }

    protected function getLastAddress()
    {
        $lastAddress = Order::select('address')
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->first();

        if (!blank($lastAddress) && isJson($lastAddress->address)) {
            return Address::where('address', json_decode($lastAddress->address, true)['address'])->first();
        }

        return Address::where('user_id', auth()->user()->id)->first();
    }

    protected function validateCheckoutRequest($request, $restaurant)
    {
        $validation = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile'       => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            'payment_type' => 'required|numeric',
        ];
        if (!$request->delivery_type) {
            $validation['street_name'] = 'required|string';
            $validation['house_number'] = 'required|string';
            $validation['post_code'] = 'required|numeric|exists:restaurant_postal_codes,postal_code';
            $validation['city'] = 'nullable|string';
            $validation['floor'] = 'nullable|string';
            $validation['company_name'] = 'nullable|string';
            $validation['note'] = 'nullable|string';
        }

        $validator = Validator::make($request->all(), $validation);

        if ($this->user) {
            $validator->after(function ($validator) use ($request, $restaurant) {
                if (
                    $request->payment_type === PaymentMethod::WALLET &&
                    (float)$this->user->balance->balance < (float)(session()->get('cart')['totalAmount'] + session()->get('delivery_charge'))
                ) {
                    $validator->errors()->add('payment_type', 'The Credit balance does not enough for this payment.');
                }
            });
        }

        return $validator;
    }

    protected function processStripePayment($restaurant)
    {
        $stripeService = new StripeService();
        $stripeParameters = [
            'amount'      => session()->get('cart')['totalAmount'] + session()->get('delivery_charge'),
            'currency'    => 'USD',
            'token'       => request('stripeToken'),
            'description' => 'N/A',
        ];

        $payment = $stripeService->payment($stripeParameters);
        $orderService = $this->handlePaymentResponse($payment);

        if ($orderService->status) {
            $order = Order::find($orderService->order_id);
            $this->clearSessionData();
            $this->sendOrderNotifications($order);
            return redirect(route('account.order.show', $order->id))->withSuccess('You order completed successfully.');
        } else {
            return redirect(route('checkout.index'))->withError($orderService->message);
        }
    }

    protected function preparePaystackPaymentData($request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . setting('paystack_secret'),
        ])->post('https://api.paystack.co/transaction/initialize', [
            'email' =>  auth()->user()->email,
            'amount' => (session()->get('cart')['totalAmount'] + session()->get('delivery_charge')) * 100, // Convert to kobo
            'callback_url' => route('paystack.callback'),
        ]);

        $responseData = $response->json();
        if (isset($responseData['data']['authorization_url'])) {
            $paymentUrl = $responseData['data']['authorization_url'];
            return redirect($paymentUrl);
        } else {
            return redirect()->route('pay')->with('error', 'Payment initialization failed. Please try again.');
        }
    }

    public function PaystackCallback()
    {
        $payment = Paystack::getPaymentData();

        if ($payment['status'] && $payment['data']['status'] === 'success') {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }

        return $this->handleOrderServiceResponse($orderService);
    }

    protected function initiatePaypalPayment()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $this->createPaypalOrder($provider);

        if (isset($response['id']) && $response['id'] != null) {
            return $this->redirectPaypalApproval($response['links']);
        } else {
            return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
        }
    }

    protected function createPaypalOrder($provider)
    {
        return $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('successTransaction'),
                'cancel_url' => route('cancelTransaction'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => setting('currency_name'),
                        'value' => session()->get('cart')['totalAmount'] + session()->get('delivery_charge'),
                    ],
                ],
            ],
        ]);
    }

    protected function redirectPaypalApproval($links)
    {
        foreach ($links as $link) {
            if ($link['rel'] == 'approve') {
                return redirect()->away($link['href']);
            }
        }

        return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
    }

    protected function processRazorpayPayment($request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $this->fetchRazorpayPayment($api, $input);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            $response = $this->captureRazorpayPayment($api, $input, $payment);

            $orderService = app(PaymentService::class)->payment($response['status'] === 'captured');
            return $this->handleOrderServiceResponse($orderService);
        } else {
            return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
        }
    }

    protected function fetchRazorpayPayment($api, $input)
    {
        return $api->payment->fetch($input['razorpay_payment_id']);
    }

    protected function captureRazorpayPayment($api, $input, $payment)
    {
        return $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);
    }

    protected function processDefaultPayment()
    {
        $orderService = app(PaymentService::class)->payment(false, $this->user);
        return $this->handleOrderServiceResponse($orderService);
    }

    protected function handleOrderServiceResponse($orderService)
    {
        if ($orderService->status) {
            $order = Order::find($orderService->order_id);
            $this->clearSessionData();
            $this->sendOrderNotifications($order);
//            dd("found Order");
            if (!auth()->check()){
                // login user
//                $user = User::find($order->user_id);
                Auth::login($this->user);
            }
            return redirect(route('account.order.show', $order->id))->withSuccess('You order completed successfully.');
        } else {
//            dd("not found Order");
            return redirect(route('checkout.index'))->withError($orderService->message);
        }
    }

    protected function clearSessionData()
    {
        session()->put('cart', null);
        session()->put('checkoutRequest', null);
        session()->put('session_cart_restaurant_id', 0);
        session()->put('session_cart_restaurant', null);
    }

    protected function sendOrderNotifications($order)
    {
        try {
            app(PushNotificationService::class)->sendNotificationOrder($order, $order->restaurant->user, 'restaurant');
            app(PushNotificationService::class)->sendNotificationOrder($order, auth()->user(), 'customer');
        } catch (\Exception $exception) {
            //
        }
    }

    protected function handlePaymentResponse($payment)
    {
        if (is_object($payment) && $payment->isSuccessful()) {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }
        return $orderService;
    }

    public function paypalSuccessTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $orderService = app(PaymentService::class)->payment(true);
        } else {
            $orderService = app(PaymentService::class)->payment(false);
        }

        return $this->handleOrderServiceResponse($orderService);
    }

    public function paypalCancelTransaction(Request $request)
    {
        return redirect(route('checkout.index'))->withError('You have canceled the transaction.');
    }
}

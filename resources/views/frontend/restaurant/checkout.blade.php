@extends('frontend.layouts.app')

@push('meta')
    <meta property="og:url" content="{{ route('checkout.index') }}">
    <meta property="og:type" content="Foodbank">
    <meta property="og:title" content="{{ setting('banner_title') }}">
    <meta property="og:description" content="Explore top-rated attractions, activities and more">
    <meta property="og:image" content="{{ asset('images/' . setting('site_logo')) }}">
@endpush

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/lib/inttelinput/css/intlTelInput.css') }}">
@endpush


@section('main-content')

    <!--=========  CHECKOUT PART Start =========-->
    <section class="checkout">
        <div class="container-fluid px-5">

            <a href="#" class="booking-paginate">
                <i class="fa-solid fa-arrow-left"></i>
                <span>{{ __('frontend.checkout') }}</span>
            </a>

            <form id="payment-form" action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="checkout-group">
                    <div class="checkout-delivery">
                        <div class="checkout-card">
                            @if (!session()->get('cart')['delivery_type'])

                                <div class="checkout-card-head">
                                    <h3>{{ __('frontend.delivery_address') }}</h3>
                                </div>

                                <fieldset class="checkout-fieldset">
                                    <div class="form-address">
                                        <div class="row justify-content-between">
                                            <div class="col-12 col-lg-6 form-group">
                                                <label class="form-label required"> {{ __('levels.street_name') }}</label>
                                                <input id="street_name" type="text" required
                                                       class="form-control @error('street_name') is-invalid @enderror street_name"
                                                       placeholder="{{ __('levels.street_name') }}" name="street_name"
                                                       value="{{ old('street_name', @$delivery_address->street_name) }}">
                                                @error('street_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-6 form-group">
                                                <label class="form-label required"> {{ __('levels.house_number') }}</label>
                                                <input id="house_number" type="text" required
                                                       class="form-control @error('house_number') is-invalid @enderror house_number"
                                                       placeholder="{{ __('levels.house_number') }}" name="house_number"
                                                       value="{{ old('house_number', @$delivery_address->house_number) }}">
                                                @error('house_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col-12 col-md-6 form-group">
                                                <label class="form-label required"> {{ __('levels.post_code') }}</label>
                                                <input id="post_code" type="number" required
                                                       class="form-control @error('post_code') is-invalid @enderror post_code"
                                                       placeholder="{{ __('levels.post_code') }}" name="post_code"
                                                       value="{{ old('post_code', @$delivery_address->postal_code) }}">
                                                @error('post_code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                <div class="post_code text-danger"></div>
                                            </div>
                                            <div class="col-12 col-md-6 form-group">
                                            <label class="form-label"> {{ __('levels.city') }}</label>
                                            <input id="city" type="text"
                                                   class="form-control @error('city') is-invalid @enderror city"
                                                   placeholder="{{ __('levels.city') }}" name="city"
                                                   value="{{ old('city', @$delivery_address->city) }}">
                                            @error('city')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col-12 col-md-6 form-group">
                                                <label class="form-label"> {{ __('levels.floor') }}</label>
                                                <input id="floor" type="text"
                                                       class="form-control @error('floor') is-invalid @enderror floor"
                                                       placeholder="{{ __('levels.floor') }}" name="floor"
                                                       value="{{ old('floor', @$delivery_address->floor) }}">
                                                @error('floor')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6 form-group">
                                            <label class="form-label"> {{ __('levels.company_name') }}</label>
                                            <input id="company_name" type="text"
                                                   class="form-control @error('company_name') is-invalid @enderror company_name"
                                                   placeholder="{{ __('levels.company_name') }}" name="company_name"
                                                   value="{{ old('company_name', @$delivery_address->company_name) }}">
                                            @error('company_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="row justify-content-between">
                                            <div class="col-12 form-group">
                                            <label class="form-label"> {{ __('levels.add_note') }}</label>
                                            <input id="note" type="text"
                                                   class="form-control @error('note') is-invalid @enderror note"
                                                   placeholder="{{ __('levels.add_note') }}" name="note"
                                                   value="{{ old('note', @$delivery_address->note) }}">
                                            @error('note')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        </div>
                                    </div>
                                </fieldset>
                            @else
                                <div class="checkout-card-head">
                                    <h3>{{ __('frontend.pickup_location') }} </h3>
                                </div>

                                <label class="checkout-label d-block" for="address">
                                    <h6 class="mb-1">{{ $restaurant->name }}</h6>
                                    <dl>
                                        <dd> {{ __('frontend.address') }} : {{ $restaurant->address }} </p>
                                        </dd>
                                    </dl>
                                </label>
                            @endif
                        </div>

                        <div class="checkout-card mb-0">
                            <div class="checkout-card-head">
                                <h3>{{ __('frontend.personal_details') }}</h3>
                            </div>

                            <div class="row justify-content-between">
                                <div class="col-12 col-md-6 form-group">
                                    <label class="form-label required">{{ __('frontend.first_name') }}</label>
                                    <input class="form-control first_name @error('first_name') is-invalid @enderror"
                                           type="text" id="first_name" name="first_name" required
                                           value={{ old('first_name', @$user->first_name) }} >

                                    @error('first_name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                <label class="form-label required">{{ __('frontend.last_name') }}</label>
                                <input class="form-control last_name @error('last_name') is-invalid @enderror"
                                       type="text" id="last_name" name="last_name" required
                                       value={{ old('last_name', @$user->last_name) }}>

                                @error('last_name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            </div>

                            <div class="row justify-content-between">
                                <div class="col-12 col-md-6 form-group">
                                    <label class="form-label required">{{ __('frontend.email_address') }}</label>
                                    <input class="form-control email @error('email') is-invalid @enderror" type="email"
                                           id="email" name="email" required
                                           value={{ old('email', @$user->email) }}>

                                    @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                <label class="form-label required">{{ __('frontend.phone_number') }}</label>
                                <input class="form-control mobile @error('mobile') is-invalid @enderror phone"
                                       type="tel" id="number" name="mobile" onkeypress='validate(event)' required
                                       value={{ old('mobile', @$user->phone) }}>

                                <input type="hidden" id="code" name="countrycode" value="1">

                                @error('mobile')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            </div>

                            <input type="hidden" name="total_delivery_charge" id="total_delivery_charge"
                                   value="0">

                            <div class="form-group mb-0">
                                <label class="form-label required">{{ __('frontend.payment_type') }}</label>

                                <div class="row justify-content-between">
                                    <div class="col-12  form-group">
                                        <select class="form-select" name="payment_type" id="payment_type"
                                                onchange="myPaymentFunction()"
                                                class="form-control @error('payment_type') is-invalid @enderror ">

                                            <option value="{{ App\Enums\PaymentMethod::CASH_ON_DELIVERY }}"
                                                    @if (old('payment_type') == App\Enums\PaymentMethod::CASH_ON_DELIVERY) selected="selected" @endif>
                                                {{ __('frontend.cash_on_delivery') }}
                                            </option>

                                            @if ($is_auth && auth()->user()->balance->balance >= $totalPayment)
                                                <option value="{{ App\Enums\PaymentMethod::WALLET }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::WALLET) selected="selected" @endif>
                                                    {{ __('frontend.pay_with_credit_balance') . currencyFormatWithName(auth()->user()->balance->balance) }}
                                                </option>
                                            @endif

                                            @if (setting('stripe_key') && setting('stripe_secret'))
                                                <option value="{{ App\Enums\PaymentMethod::STRIPE }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::STRIPE) selected="selected" @endif>

                                                    {{ __('frontend.stripe') }}
                                                </option>
                                            @endif

                                            @if (setting('paystack_key') && setting('paystack_secret'))
                                                <option value="{{ App\Enums\PaymentMethod::PAYSTACK }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::PAYSTACK) selected="selected" @endif>
                                                    {{ __('frontend.paystack') }}
                                                </option>
                                            @endif

                                            @if (setting('paypal_client_id') && setting('paypal_client_secret'))
                                                <option value="{{ App\Enums\PaymentMethod::PAYPAL }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::PAYPAL) selected="selected" @endif>
                                                    {{ __('frontend.paypal') }}
                                                </option>
                                            @endif

                                            @if (setting('razorpay_key') && setting('razorpay_secret'))
                                                <option value="{{ App\Enums\PaymentMethod::RAZORPAY }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::RAZORPAY) selected="selected" @endif>
                                                    {{ __('frontend.razorpay') }}
                                                </option>
                                            @endif

                                            @if (setting('paytm_merchant_id') && setting('paytm_merchant_key'))
                                                <option value="{{ App\Enums\PaymentMethod::PAYTM }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::PAYTM) selected="selected" @endif>
                                                    {{ __('frontend.paytm') }}
                                                </option>
                                            @endif

                                            @if (setting('phonepe_merchant_id') && setting('phonepe_merchant_user_id') && setting('phonepe_salt_key'))
                                                <option value="{{ App\Enums\PaymentMethod::PHONEPE }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::PHONEPE) selected="selected" @endif>
                                                    {{ __('frontend.phonePe') }}
                                                </option>
                                            @endif


                                            @if (setting('sslcommerz_store_id') && setting('sslcommerz_store_password'))
                                                <option value="{{ App\Enums\PaymentMethod::SSLCOMMERZ }}"
                                                        @if (old('payment_type') == App\Enums\PaymentMethod::SSLCOMMERZ) selected="selected" @endif>
                                                    {{ __('frontend.sslcommerz') }}
                                                </option>
                                            @endif

                                        </select>
                                        @error('payment_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row no-margin-row ms-2">
                            <div class="w-100 form-group col-sm-6 stripe-payment-method-div">
                                <label class="form-label">{{ __('frontend.credit_or_debit_card') }}</label>
                                <div id="card-element"></div>
                                <div id="card-errors" class="text-danger" role="alert"></div>
                            </div>
                        </div>

                        <button type="submit" class="form-btn booking-confirmation-btn"
                                @if ($menuitems['totalAmount'] <= 0) disabled @endif>
                            {{ __('frontend.place_order') }}
                        </button>

                    </div>

                    <div class="checkout-summary">
                        <div class="checkout-summary-head">
                            <h3>{{ __('frontend.order_summary') }} </h3>
                            <p>
                                {{ __('frontend.your_order_from') . ' ' . $restaurant->name }}
                            </p>
                        </div>
                        <ul class="checkout-summary-list">
                            @if (!blank($menuitems))
                                @foreach ($menuitems['items'] as $item)
                                    <li class="checkout-summary-item">
                                        <h3>
                                            <span>{{ $item['qty'] }}</span>
                                            <i class="fa-solid fa-xmark"></i>
                                        </h3>
                                        <dl>
                                            <dt>{{ $item['name'] }} </dt>
                                            @if (isset($item['variation']['name']) && isset($item['variation']['price']))
                                                <dd class="fw-bold">{{ $item['variation']['name'] }} </dd>
                                            @endif
                                            @if (!blank($item['options']))
                                                @foreach ($item['options'] as $option)
                                                    <dd>+ {{ $option['name'] }}</dd>
                                                @endforeach
                                            @endif
                                        </dl>
                                        <h4>{{ currencyFormat($item['totalPrice']) }} </h4>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <ul class="checkout-summary-price-list">
                            <li>
                                <span>{{ __('frontend.subtotal') }}</span>
                                <span class="sub_aj"> {{ currencyFormat($menuitems['subTotalAmount']) }}</span>
                            </li>

                            @if ($menuitems['delivery_type'] != true)
                                <li>
                                    <span>{{ __('frontend.delivery_charge') }}</span>
                                    <span>
                                        <span class="get_delivery_charge" id="delivery_chearge">
                                            {{ $restaurant->lowestDeliveryCharge()?->min_order }}
                                        </span>
                                    </span>
                                </li>
                            @endif
                            @if (Schema::hasColumn('coupons', 'slug'))
                                <li>
                                    <span>{{ __('frontend.discount') }}</span>
                                    <span> {{ currencyFormat($menuitems['coupon_amount']) }} </span>
                                </li>
                            @endif

                            <li>
                                <span>{{ __('frontend.total') }}</span>
                                <span><span class="total_aj" id="total"></span></span>
                            </li>
                        </ul>
                        <div class="text-danger p-3 min_order_msg"></div>
                    </div>

                </div>
            </form>
        </div>
    </section>
    <!--======= CHECKOUT PART END =========-->


    <!--===== ADDRESS MODAL PART START =======-->
    @if ($is_auth)
        <div class="modal fade address-modal" id="address-modal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addressForm" method="post">
                        <input id="formMethod" type="hidden" name="_method" value="POST">
                        @csrf
                        <input type="hidden" name="lat" id="lat" value="">
                        <input type="hidden" name="long" id="long" value="">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="address-modal-header">
                            <h3> {{ __('levels.add_new_address') }}</h3>
                            <button class="fa-regular fa-circle-xmark" type="button" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="address-modal-search modalAddressSearch justify-content-between">
                            <i class="lni lni-search-alt"></i>

                            <div id="autocomplete-container" class="w-100">
                                <input id="autocomplete-input"
                                       class="address autocomplete-input @error('new_address') is-invalid @enderror"
                                       name="new_address" type="text" placeholder="{{ __('frontend.search') }}">
                            </div>
                            <a href="javascript:void(0)">
                                <button id="locationIcon" onclick="getLocation()"
                                        class="lni lni-target iconSearch"></button>
                            </a>
                        </div>
                        <div class="">
                            <div id="googleMap" class="custom-map">

                            </div>
                        </div>
                        <div class="address-modal-details">
                            <label> {{ __('levels.apartment_flat') }}</label>
                            <input id="apartment" type="text"
                                   class="form-control @error('apartment') is-invalid @enderror apartment"
                                   placeholder="{{ __('levels.apartment') }}" name="apartment"
                                   value="{{ old('apartment') }}">
                            @error('apartment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="address-modal-label-group">
                            <h4 class="address-modal-label-title">{{ __('levels.select_label') }}</h4>

                            <select name="label" id="label" class="w-100 border-1">
                                <option value="" disabled selected>{{ __('levels.select_label') }}</option>

                                @foreach (trans('address_types') as $key => $value)
                                    <option value="{{ $key }}" <?= old('label') ? 'selected' : '' ?>>
                                        {{ $value }}</option>
                                @endforeach
                            </select>

                            @error('label')
                            <div class="text-danger check-errors1">
                                {{ $message }}
                            </div>
                            @enderror

                            <div id="other">
                                <input id="label_name" type="text"
                                       class="address-modal-label-input label-name @error('label_name') is-invalid @enderror"
                                       placeholder="{{ __('levels.label_example') }}" name="label_name"
                                       value="{{ old('label_name') }}">

                                @error('label_name')
                                <div class="text-danger check-errors2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="text-danger jsalert">

                            </div>
                        </div>

                        <button class="form-btn" id="address-btn">{{ __('levels.confirm_location') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!--======== ADDRESS MODAL PART END ===========-->

@endsection


@push('js')
    <!-- INTTELINPUT for frontend -->
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/utils.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/data.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/init.js') }}"></script>


    <!-- For backend Js -->
    <script async
            src="https://maps.googleapis.com/maps/api/js?key={{ setting('google_map_api_key') }}&libraries=places&callback=initMap">
    </script>
    <script src="{{ asset('frontend/js/checkout/map.js') }}"></script>

    <script>
        function deleteBtn(e, id) {
            let url = $(e).attr('data-url');
            var token = $("meta[name='csrf-token']").attr("content");
            if (confirm("Are you sure you want to delete this address ?")) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function() {
                        iziToast.success({
                            title: 'Success',
                            message: 'Address Successfully Deleted.',
                            position: 'topRight'
                        });
                        window.location.reload();
                    }
                });
            }
        }

        let totalAmount = 0;

        function myPaymentFunction() {
            totalAmount = Number($('#total').text());
        }

        const siteName = "{{ setting('site_name') }}";
        let orderType = "{{ session()->get('cart')['delivery_type'] }}";
        const siteLogo = "{{ asset('images/' . setting('site_logo')) }}";
        const currencyName = "{{ setting('currency_name') }}";
        const razorpayKey = "{{ env('RAZORPAY_KEY') }}";
        const stripeKey = "{{ setting('stripe_key') }}";
        const subtotal = "{{ $menuitems['subTotalAmount'] }}";
        const couponAmount = "{{ $menuitems['coupon_amount'] }}";
        const locationLat = parseFloat("{{ $restaurant->lat }}");
        const locationLong = parseFloat("{{ $restaurant->long }}");
        const freeZone = "{{ setting('free_delivery_radius') }}";
        const basicCharge = "{{ setting('basic_delivery_charge') }}";
        const chragePerKilo = "{{ setting('charge_per_kilo') }}";
        const delivery_type = "{{ $menuitems['delivery_type'] }}";

        const lastAddress = "{{ !blank($lastAddress) ? true : false }}";
        const lastAddress_latitude = parseFloat("{{ optional($lastAddress)->latitude }}");
        const lastAddress_longitude = parseFloat("{{ optional($lastAddress)->longitude }}");
    </script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('frontend/js/checkout/stripe.js') }}"></script>
    <script src="{{ asset('frontend/js/image-upload.js') }}"></script>
    <script src="{{ asset('js/phone_validation/index.js') }}"></script>

    <script>
        $(document).ready(function() {
            let address = localStorage.getItem('address');
          
            if (address) {
                address = JSON.parse(address);
                $('#street_name').val(address.street);
                $('#city').val(address.city);
                $('#post_code').val(address.postalCode);
            }

            setTimeout(() => {
                let post_code_val = $('#post_code').val();
                if (post_code_val) {
                    $('#post_code').trigger('input');
                }
            }, 1000);


            $("#post_code").on('input', function() {
                var postCode = $('#post_code').val();
                $.ajax({
                    type:'POST',
                    url:'/checkPostal',
                    data:{
                        _token: "{{ csrf_token() }}",
                        postCode: postCode
                    },
                    dataType: "json",
                    success:function(data) {

                        console.log(data);
                        if(data.status=='success'){
                            $('.sub_aj').text(data.subtotal);
                            $('.get_delivery_charge').text(data.delivery);
                            $('.total_aj').text(data.total);
                            $('.post_code').text('');
                            $('.min_order_msg').text('');
                            $('.booking-confirmation-btn').prop("disabled", false);

                        }else{
                            if(data.msg_for=='postcode'){
                                $('.min_order_msg').text('');
                                $('.post_code').text(data.msg);
                                $('.booking-confirmation-btn').prop("disabled", true);
                            }else if(data.msg_for=='min_order'){
                                $('.post_code').text('');
                                $('.min_order_msg').text(data.msg);
                                $('.booking-confirmation-btn').prop("disabled", true);
                            }else{
                                $('.post_code').text('');
                                $('.min_order_msg').text('');
                                $('.booking-confirmation-btn').prop("disabled", false);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush

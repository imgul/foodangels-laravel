<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Services\RestaurantService;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\MenuItem;
use App\Enums\OrderStatus;
use App\Models\Restaurant;
use App\Enums\RatingStatus;
use App\Enums\DiscountStatus;
use App\Enums\MenuItemStatus;
use Illuminate\Support\Carbon;
use App\Models\RestaurantRating;
use Sopamo\LaravelFilepond\Filepond;
use App\Http\Requests\RatingsRequest;
use App\Http\Services\RatingsService;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Cache;

class RestaurantController extends FrontendController
{
    protected $restaurant;
    protected $filepond;

    public function __construct(protected RatingsService $ratingsService, Filepond $filepond)
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';
    }

    public function show(Restaurant $restaurant, Filepond $filepond)
    {
//        $this->restaurant = $restaurant;
        $this->restaurant = Cache::remember("restaurant_{$restaurant->id}", 60, function() use ($restaurant) {
            return $restaurant->load(['media']);
        });
        $this->filepond   = $filepond;

        if (session('session_cart_restaurant_id') != $this->restaurant->id) {
            session()->forget('cart');
        }

        $this->loadCategoriesAndProducts();
        $this->loadRatings();
        $this->data['order_status'] = auth()->id() ? Order::where(['restaurant_id' => $this->restaurant->id, 'status' => OrderStatus::COMPLETED, 'user_id' => auth()->id()])->get() : [];
        $this->loadVouchers();
        $this->loadViewData();


        return view('frontend.restaurant.show', $this->data);
    }

    private function loadCategoriesAndProducts()
    {
        $categories = [];
        $other_products = [];
        $categories_products = [];

        $products = MenuItem::with(['categories_orderBy', 'media', 'variations', 'options'])
            ->where('restaurant_id', $this->restaurant->id)
            ->where('status', MenuItemStatus::ACTIVE)
            ->get();


        foreach ($products as $product) {
            $product_categories = $product->categories_orderBy;
            if (!blank($product_categories)) {
                foreach ($product_categories as $product_category) {
                    $categories[$product_category->id] = $product_category;
                    $categories_products[$product_category->id][] = $product;
                }
            } else {
                $other_products[] = $product;
            }
        }

        
        $this->data['categories'] = $categories;

        $this->data['other_products'] = $other_products;
        $this->data['categories_products'] = $categories_products;
    }

    private function loadRatings()
    {
        $this->data['ratings'] = Cache::remember("ratings_{$this->restaurant->id}", 60, function() {
            return RestaurantRating::with('user')
                ->where(['restaurant_id' => $this->restaurant->id, 'status' => RatingStatus::ACTIVE])
                ->paginate(5);
        });

        $ratingInfo = $this->ratingsService->avgRating($this->restaurant->id);
        $this->data['rating_user_count'] = $ratingInfo['countUser'];
        $this->data['average_rating'] = $ratingInfo['avgRating'];
    }

    private function loadVouchers()
    {
        $today = now();
        $this->data['vouchers'] = Cache::remember("vouchers_{$this->restaurant->id}", 60, function() use ($today) {
            $vouchers = Coupon::whereDate('to_date', '>', $today)
                ->where('restaurant_id', $this->restaurant->id)
                ->whereDate('from_date', '<', $today)
                ->where('limit', '>', 0)
                ->get();

            if (!blank($vouchers)) {
                $data = [];
                foreach ($vouchers as $voucher) {
                    $total_used = Discount::where('coupon_id', $voucher->id)
                        ->where('status', DiscountStatus::ACTIVE)
                        ->count();
                    if ($total_used < $voucher->limit) {
                        $data[] = $voucher;
                    }
                }

                return pluck($data, 'obj', 'restaurant_id');
            }
            return [];
        });
    }

    private function loadViewData()
    {
        // $this->data['currenttime'] = now()->format('H:i:s');
        $this->restaurant->is_open = RestaurantService::isOpen($this->restaurant);

        $this->data['restaurant'] = $this->restaurant;

        $qrCodeMediaItem = $this->restaurant->getFirstMedia('qrcode');
//        $this->data['qrCode'] = $qrCodeMediaItem ? $qrCodeMediaItem->getUrl() : $this->qrCode();
        if($qrCodeMediaItem){
            $this->data['qrCode'] = $qrCodeMediaItem->getUrl();
            $this->data['qrCodeFound'] = true;
        } else {
            $this->data['qrCode'] = $this->qrCode();
            $this->data['qrCodeFound'] = false;
        }
    }

    private function qrCode()
    {
        if ($this->restaurant) {
            $image = QrCode::size(480)->format('png')->margin(1)->encoding('UTF-8');

            if (isset($this->restaurant->qrCode)) {
                $colors = isset($this->restaurant->qrCode->color) ? explode(",", $this->restaurant->qrCode->color) : [0, 0, 0];
                $bgColors = isset($this->restaurant->qrCode->background_color) ? explode(",", $this->restaurant->qrCode->background_color) : [255, 255, 255];

                $image = $image
                    ->style($this->restaurant->qrCode->style ?? 'square')
                    ->eye($this->restaurant->qrCode->eye_style ?? 'square')
                    ->color((int)$colors[0], (int)$colors[1], (int)$colors[2])
                    ->backgroundColor((int)$bgColors[0], (int)$bgColors[1], (int)$bgColors[2]);

                if ($this->restaurant->qrCode->mode == 'logo' && !blank($this->restaurant->qrCode->qrcode_logo)) {
                    $path = $this->filepond->getPathFromServerId($this->restaurant->qrCode->qrcode_logo);
                    $image = $image->merge($path, .2, true);
                }
            }

            return base64_encode($image->generate(route('restaurant.show', $this->restaurant->slug)));
        }
    }

    public function Ratings(RatingsRequest $request)
    {
        $restaurantRating = RestaurantRating::updateOrCreate(
            ['user_id' => auth()->id(), 'restaurant_id' => $request->restaurant_id],
            ['rating' => $request->rating, 'review' => $request->review, 'status' => $request->status]
        );

        return Redirect::back()->withSuccess('The Data ' . ($restaurantRating->wasRecentlyCreated ? 'Inserted' : 'Updated') . ' Successfully');
    }
}

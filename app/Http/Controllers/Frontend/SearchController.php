<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\DeliveryType;
use App\Models\Restaurant;
use App\Models\MenuItem;
use Carbon\Carbon;
use App\Enums\Status;
use App\Models\Cuisine;
use App\Enums\TableStatus;
use App\Enums\PickupStatus;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Enums\DeliveryStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Services\RatingsService;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Session;

class SearchController extends FrontendController
{

    protected $expeditionMap;
    public function __construct(protected RatingsService $ratingService)
    {
        parent::__construct();
        $this->data['site_title'] = 'Search Restaurants';
        $this->expeditionMap = [
            'delivery' => DeliveryStatus::ENABLE,
            'pickup' => PickupStatus::ENABLE,
            'table' => TableStatus::ENABLE,
        ];
    }

    public function filter(Request $request)
    {
        $request->validate([
            's' => 'required'
        ]);

        $restaurant = Restaurant::where(['status' => Status::ACTIVE, 'current_status' => Status::ACTIVE])->first();

        $current_time = now()->format('H:i:s');
        $restaurant->is_open = false;
        if ($restaurant->opening_time < $current_time && $restaurant->closing_time > $current_time){
            $restaurant->is_open = true;
        }

        return redirect()->route('restaurant.show', $restaurant->slug);
    }

    public function filters(Request $request)
    {
        $rating        = new RatingsService();
        $totalReview   = [];
        $averageRating = [];
        $is_closed = true;
        $is_delivery =true;
        $current_time = now()->format('H:i');
        $restaurants = Restaurant::selectRaw('*, IF((opening_time < "' . now()->format('H:i') . '" and closing_time > "' . now()->format('H:i') . '"), true, false) as open,lat,`long`')
            ->where(function ($query) use ($current_time) {
                $query->where(['status' => Status::ACTIVE, 'current_status' => Status::ACTIVE,'pickup_status' => Status::ACTIVE]);
                $query->where([['opening_time', '<', $current_time], ['closing_time', '>', $current_time]]);

            })->get();
        Session::put('restaurant_d_type', true);
        Session::put('delivery_type', DeliveryType::PICKUP);
        if ($restaurants->isEmpty()) {
            $Restaurant = Restaurant::where('slug', 'foodangels')->first();
            $this->data['featured']=  MenuItem::with('media')->where(['restaurant_id'=>$Restaurant->id,'is_featured'=>1])->get();
            $opening_time = $Restaurant->week_days_opening;
            $closing_time = $Restaurant->week_days_closing;
            $this->data['restaurant']     = $Restaurant;

            $weekdays = [];

            $period = new CarbonPeriod($opening_time, '30 minutes', $closing_time); // for create use 24 hours format later change format
            foreach($period as $item){
                array_push($weekdays,$item->format("h:i A"));
            }
            $this->data['weekdays']     = $weekdays;
            $weekend = [];
            $period = new CarbonPeriod($Restaurant->weekend_opening, '30 minutes', $Restaurant->weekend_closing); // for create use 24 hours format later change format
            foreach($period as $item){
                array_push($weekend,$item->format("h:i A"));
            }
            $this->data['weekend']     = $weekend;
            $this->data['restaurants'] = [];
            $this->data['is_pickup'] =false;

            return view('frontend.search', $this->data);
        }else{
            session()->put('postal_code',null);

            $restaurant=$request->get('restaurant');
            return redirect(route('restaurant.show', [$restaurant]));

        }

    }

    public function filterOld(Request $request){
        $expedition = $request->get('expedition');

        $restaurants = Restaurant::query()
            ->with('media')
            ->where(['status' => Status::ACTIVE, 'current_status' => Status::ACTIVE]);

        if (!blank($request->get('cuisines'))) {
            $cuisineSlugs = $request->get('cuisines');
            $restaurants->whereHas('cuisines', function ($query) use ($cuisineSlugs) {
                $query->whereIn('slug', $cuisineSlugs);
            });
        }

        if (!blank($request->get('query'))) {
            $query = $request->get('query');
            $restaurants->where('name', 'like', '%' . $query . '%');
        }

        if (array_key_exists($expedition, $this->expeditionMap)) {
            $statusColumn = $expedition . '_status';
            $status = $this->expeditionMap[$expedition];
            $restaurants->where($statusColumn, $status);
        }

        if(!blank($request->get('lat')) && !blank($request->get('long'))) {
            $restaurants->where(['status' => 5])
            ->select(DB::raw('*, ( 6367 * acos( cos( radians('.$request->get('lat').') ) * cos( radians( `lat` ) ) * cos( radians( `long` ) - radians('.$request->get('long').') ) + sin( radians('.$request->get('lat').') ) * sin( radians( `lat` ) ) ) ) AS distance'))
                ->having('distance', '<', $request->get('distance') ?? setting('geolocation_distance_radius'))
                ->orderBy('distance');
        }

        $mapRestaurants = $restaurants->with('media')->get()->map(function ($restaurant) {
            return [
                'name' => $restaurant->name,
                'slug' => $restaurant->slug,
                'image' => $restaurant->image,
                'logo' => $restaurant->logo,
                'lat' => $restaurant->lat,
                'long' => $restaurant->long,
                'address' => $restaurant->address,
                'url' => route('restaurant.show', [$restaurant]),
            ];
        })->all();

        $this->data['cuisines'] = Cuisine::select('id', 'name', 'slug')->orderBy('name', 'desc')->get();
        $this->data['restaurants'] = $restaurants->paginate(8)->appends(request()->query());
        $this->data['mapRestaurants'] = $mapRestaurants;
        $this->data['current_data'] = Carbon::now()->format('H:i:s');
        return view('frontend.search', $this->data);
    }

    public function filterTest(Request $request)
    {

//        $this->validate($request, ['search' => 'required']);
        $lat=$request->get('lat');
        $lng=$request->get('long');
        $current_time = now()->format('H:i');
//        dd("good");
        //$restaurants = Restaurant::selectRaw('*, IF((opening_time < "' . now()->format('H:i') . '" and closing_time > "' . now()->format('H:i') . '"), true, false) as open,( 3959 * acos( cos( radians( '.$lat.' ) ) * cos( radians( lat ) ) * cos( radians( long ) - radians( '.$lng.' ) ) + sin( radians( '.$lat.') ) * sin( radians( lat ) ) ) ) as distance')
        $restaurants = Restaurant::selectRaw('*, IF((opening_time < "' . now()->format('H:i') . '" and closing_time > "' . now()->format('H:i') . '"), true, false) as open,lat,`long`')
            ->where(function ($query) use ($request, $current_time) {
                $query->where([ 'current_status' => Status::ACTIVE]);

                if (!blank($request->get('minimumOrder'))) {
                    if ($request->get('minimumOrder') != "all") {
                        $minimumOrder = (int) $request->get('minimumOrder');
                        $code = $request->get('postal_code');
                        $query->whereHas('restaurantPostalCode', function ($querys) use ($minimumOrder, $code) {
                            $querys->where('postal_code', $code);
                            $querys->where('min_order', '<', $minimumOrder);
                        });
                    }
                }

                $query->where([['opening_time', '<', $current_time], ['closing_time', '>', $current_time]]);

                if (!blank($request->get('postal_code'))) {
                    $code = $request->get('postal_code');
                    $query->whereHas('restaurantPostalCode', function ($queryPostal) use ($code) {
                        $queryPostal->where('postal_code', $code);
                    });
                }

                if (!blank($request->get('lat')) && !blank($request->get('long'))) {
                    $lat=$request->get('lat');
                    $lng=$request->get('long');
                    $distance=(!blank($request->get('distance')))?$request->get('distance'):100;
                    $query->whereRaw("( 3959 * acos( cos( radians( $lat ) ) * cos( radians( `lat` ) ) * cos( radians( `long` ) - radians( $lng ) ) + sin( radians( $lat) ) * sin( radians( `lat` ) ) ) )<'$distance'");

                }

                // if (!blank($request->get('expedition'))) {
                //     if ($request->get('expedition') == 'delivery') {
                //         $query->where('delivery_status', DeliveryStatus::ENABLE);
                //     } elseif ($request->get('expedition') == 'pickup') {
                //         $query->where('pickup_status', PickupStatus::ENABLE);
                //     }
                // }

                if (!blank($request->get('open'))) {
                    if ($request->get('open') == 'true') {
                        $query->where('current_status', Status::ACTIVE);
                    }
                }

                if (!blank($request->get('delivery_free'))) {
                    if ($request->get('delivery_free') == 'true') {
                        $query->whereHas('restaurantPostalCode', function ($queryDelivery) {
                            $queryDelivery->where('delivery_charge', 0.00);
                        });
                    }
                }
            })->with('media');



        if (!blank($request->get('postal_code'))) {
            $is_postalCode = true;
            session()->put('postal_code', null);
            session()->put('postal_code', $request->get('postal_code'));
        } else {
            $is_postalCode = false;
        }

        if (!blank($request->get('city_name'))) {
            session()->put('city_name', null);
            session()->put('city_name', $request->get('city_name'));
        }

        if (!blank($request->get('street_name'))) {
            session()->put('street_name', null);
            session()->put('street_name', $request->get('street_name'));
        }

        $rating        = new RatingsService();
        $totalReview   = [];
        $averageRating = [];
        $is_closed = true;
        $is_pickup =true;
        $is_delivery =true;
        if (!blank($restaurants->get())) {
            foreach ($restaurants->get() as $value) {
                if ($value->current_status == Status::ACTIVE && $is_postalCode == true) {
                    $is_closed = true;
                } else {
                    $is_closed = false;
                }
                if($value->delivery_status == Status::ACTIVE){
                    $is_delivery =true;
                }else{
                    $is_delivery =false;
                }
                // if($value->pickup_status == Status::ACTIVE){
                //    $is_pickup =true;
                // }else{
                //    $is_pickup =false;
                // }
            }
        }
        if ($is_closed == false) {
            $this->data['restaurants'] = [];
            $this->data['is_closed'] = true;
            $this->data['is_postalCode'] = $is_postalCode;
            return view('frontend.search', $this->data);
        }
        if($is_delivery == false){

            $this->data['restaurants'] = [];
            $this->data['is_delivery'] =false;
            $this->data['is_postalCode'] = $is_postalCode;
            return view('frontend.search', $this->data);
        }
        // if($is_pickup == false){

        //     $this->data['restaurants'] = [];
        //     $this->data['is_pickup'] =false;
        //     $this->data['is_postalCode'] = $is_postalCode;
        //     return view('frontend.search', $this->data);
        // }

        foreach ($restaurants->get() as $key => $restaurant) {
            $ratingArray                      = $rating->avgRating($restaurant->id);
            $totalReview[$restaurant->id]       = $ratingArray['countUser'];
            $averageRating[$restaurant->id]       = $ratingArray['avgRating'];
            $maprestaurants[$key]['name']      = $restaurant->name;
            $maprestaurants[$key]['slug']      = $restaurant->slug;
            $maprestaurants[$key]['image']     = $restaurant->image;
            $maprestaurants[$key]['logo']      = $restaurant->logo;
            $maprestaurants[$key]['avgRating'] = $ratingArray['avgRating'];
            $maprestaurants[$key]['countUser'] = $ratingArray['countUser'];
            $maprestaurants[$key]['lat']       = $restaurant->lat;
            $maprestaurants[$key]['long']      = $restaurant->long;
            $maprestaurants[$key]['address']   = $restaurant->address;
            $maprestaurants[$key]['url']       = route('restaurant.show', [$restaurant]);
        }
        $this->data['is_closed']     = false;
        $this->data['is_postalCode'] = $is_postalCode;
        $this->data['restaurants']      = $restaurants->paginate(8)->appends(request()->query());
        $this->data['totalReview']   = $totalReview;
        $this->data['averageRating'] = $averageRating;
        //return view('frontend.search', $this->data);
        $Restaurant = Restaurant::where('slug', 'foodangels')->first();
        $this->data['featured']=  MenuItem::with('media')->where(['restaurant_id'=>$Restaurant->id,'is_featured'=>1])->get();
        $this->data['restaurant']     = $Restaurant;
        $opening_time = $Restaurant->week_days_opening;
        $closing_time = $Restaurant->week_days_closing;

// echo "<pre>"; print_r( $this->data['is_closed']); die;


        $weekdays = [];

        $period = new CarbonPeriod($opening_time, '30 minutes', $closing_time); // for create use 24 hours format later change format
        foreach($period as $item){
            array_push($weekdays,$item->format("h:i A"));
        }
        $this->data['weekdays']     = $weekdays;
        $weekend = [];
        $period = new CarbonPeriod($Restaurant->weekend_opening, '30 minutes', $Restaurant->weekend_closing); // for create use 24 hours format later change format
        foreach($period as $item){
            array_push($weekend,$item->format("h:i A"));
        }
        $this->data['weekend']     = $weekend;
        // echo "<pre>"; print($restaurants->get()->count());die;
        Session::put('restaurant_d_type', false);
        Session::put('delivery_type', DeliveryType::DELIVERY);
        if ($restaurants->get()->count() != 0 && $restaurants->get()->count() <= 1 && $request->get('homepage')) {

            return redirect(route('restaurant.show', [$maprestaurants[0]['slug']]));
        } else {
            return view('frontend.search', $this->data);
        }
    }
}

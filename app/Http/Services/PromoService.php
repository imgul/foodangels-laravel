<?php


namespace App\Http\Services;

use App\Enums\Status;
use App\Models\MenuItem;
use App\Models\Promo;
use App\Models\PromotionMenus;


class PromoService
{

    public function allPromos()
    {
        $this->data['promos'] =  Promo::all();
        if(auth()->user()->restaurant_id != 0){
            $this->data['promos'] =  Promo::where('restaurant_id',auth()->user()->restaurant_id)->get();
        }
        return $this->data;

    }

    public function show($id)
    {
        $this->data['promo'] =  Promo::findOrFail($id);
        $menuIds = pluck(PromotionMenus::where('promo_id', $id)->get(), 'menu_id', 'menu_id');
        $allMenus = pluck(MenuItem::with('restaurant')->where('status', Status::ACTIVE)->get(), 'obj', 'id');
        $this->data['menus'] = [];
        foreach ($menuIds as $menuID) {
            if (array_key_exists($menuID, $allMenus)) {
                $this->data['menus'][] = $allMenus[$menuID];
            }
        }

        return $this->data;
    }

    public function store($request)
    {
        $promo                = new Promo;
        $promo->name          = $request->name;
        $promo->amount        = $request->amount;
        $promo->status        = $request->status;
        $promo->restaurant_id = $request->restaurant_id;
        $promo->from_date     = $request->from_date;
        $promo->to_date       = $request->to_date;
        $promo->user_limit    = $request->user_limit;
        $promo->save();

        return $promo;
    }

    public function update($id, $request)
    {
        $promo                       = Promo::findOrFail($id);
        $promo->name          = $request->name;
        $promo->amount        = $request->amount;
        $promo->status        = $request->status;
        $promo->restaurant_id     = $request->restaurant_id;
        $promo->from_date     = $request->from_date;
        $promo->to_date       = $request->to_date;
        $promo->user_limit       = $request->user_limit;
        $promo->save();

        return $promo;
    }

    public function getMenus($id)
    {
        $this->data['promoID'] = $id;
        $this->data['promo'] = Promo::find($id);
        $this->data['oldMenus'] = pluck(PromotionMenus::where('promo_id', $id)->get(), 'menu_id', 'menu_id');
       // Get the IDs of menu items associated with promotions, excluding the current promotion
$existExceptCurrentPromoMenu = PromotionMenus::where('promo_id', '!=', $id)->pluck('menu_id');

if (auth()->user()->restaurant_id) {
    // If the authenticated user has a restaurant ID, fetch menu items for that restaurant
    $this->data['allMenus'] = MenuItem::where('restaurant_id', auth()->user()->restaurant_id)
        ->whereNotIn('id', $existExceptCurrentPromoMenu) // Exclude menu items associated with other promotions
        ->where('status', Status::ACTIVE) // Only fetch menu items with an "ACTIVE" status
        ->latest() // Order by the latest
        ->get(); // Retrieve the results
} else {
    // If the authenticated user doesn't have a restaurant ID, fetch all menu items
    $this->data['allMenus'] = MenuItem::whereNotIn('id', $existExceptCurrentPromoMenu) // Exclude menu items associated with other promotions
        ->where('status', Status::ACTIVE) // Only fetch menu items with an "ACTIVE" status
        ->latest() // Order by the latest
        ->get(); // Retrieve the results
}

        return $this->data;
    }

    public function saveMenus($request)
    {
        $promo = Promo::find($request->promo_id);
        $restaurant_id = $promo->restaurant_id;
        $deleteOldMenus = PromotionMenus::where(['promo_id' => $promo->id])->delete();

        if (!blank($request->menus)) {
            foreach ($request->menus as $menuID) {
                $promo_menu = new PromotionMenus();
                $promo_menu->promo_id = $promo->id;
                $promo_menu->menu_id = $menuID;
                $promo_menu->restaurant_id = $restaurant_id;
                $promo_menu->save();
            }
        }
        return $promo;
    }
}

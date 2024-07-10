<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restaurant;
use Carbon\Carbon;
use App\Models\Promo;
use App\Models\Branch;
use App\Models\Coupon;
use App\Models\Discount;
use App\Enums\CouponStatus;
use App\Enums\Status;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\PromoRequest;
use App\Http\Services\PromoService;
use App\Http\Controllers\BackendController;
use App\Models\MenuItem;
use App\Models\PromotionMenus;

class PromoController extends BackendController
{


    protected $promoService;
    public function __construct(PromoService $promoService)
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Promos';
        $this->promoService = $promoService;
        $this->middleware(['permission:promo'])->only('index');
        $this->middleware(['permission:promo_create'])->only('create', 'store');
        $this->middleware(['permission:promo_edit'])->only('edit', 'update');
        $this->middleware(['permission:promo_delete'])->only('destroy');
        $this->middleware(['permission:promo_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getPromo($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['menus'] = MenuItem::select('id', 'restaurant_id', 'name', 'unit_price', 'discount_price')->descending()->get();
        if (auth()->user()->restaurant_id != 0) {
            $this->data['menus'] = MenuItem::select('id', 'restaurant_id', 'name', 'unit_price', 'discount_price')->where('restaurant_id', auth()->user()->restaurant_id)->descending()->get();
        }
        $this->data['restaurants'] = Restaurant::select('id', 'name')->get();
        return view('admin.promo.create', $this->data);
    }


    public function store(PromoRequest $request)
    {
        $promo = $this->promoService->store($request);
        return redirect(route('admin.promo.index'))->withSuccess('The data inserted successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['promo'] = Promo::findOrFail($id);
        $this->data['restaurants'] = Restaurant::select('id', 'name')->get();
        return view('admin.promo.edit', $this->data);
    }


    public function update(PromoRequest $request, $id)
    {
        $promo = $this->promoService->update($id, $request);
        return redirect(route('admin.promo.index'))->withSuccess('The data updated successfully.');
    }


    public function show($id)
    {
        $this->data['promo'] =  Promo::findOrFail($id);
        $menuIds = pluck(PromotionMenus::where('promo_id', $id)->get(), 'menu_id', 'menu_id');
        $allMenus = pluck(MenuItem::with('branch')->where('status', Status::ACTIVE)->get(), 'obj', 'id');
        $this->data['menus'] = [];
        foreach ($menuIds as $menuID) {
            if (array_key_exists($menuID, $allMenus)) {
                $this->data['menus'][] = $allMenus[$menuID];
            }
        }
        return view('admin.promo.show', $this->data);
    }




    public function destroy($id)
    {
        PromotionMenus::where('promo_id',$id)->delete();
        Promo::findOrFail($id)->delete();
        return redirect(route('admin.promo.index'))->withSuccess('The data deleted successfully.');
    }

    private function getPromo($request)
    {
        if (request()->ajax()) {

            if (!empty($request->startDate)) {
                $startDate =  date('Y-m-d H:i:s', strtotime($request->startDate));
                $endDate   = date('Y-m-d H:i:s', strtotime($request->endDate));
                $promos    = Promo::where(function ($query) use (
                    $startDate,
                    $endDate
                ) {
                    if (!blank($startDate)) {
                        $query->whereBetween('from_date', [$startDate, $endDate]);
                    }
                })->latest()->get();
            } else {
                $promos = Promo::descending()->get();
            }

            $allPromos = [];
            if (auth()->user()->restaurant_id != 0) {

                foreach ($promos as $promo) {
                    if ($promo->restaurant_id == auth()->user()->restaurant_id) {
                        $allPromos[] = $promo;
                    }
                }
            } else {
                $allPromos = $promos;
            }

            $i = 0;
            return Datatables::of((object)$allPromos)
                ->addColumn('action', function ($promo) {
                    $retAction = '';

                    if ($promo->action_button) {

                        if (auth()->user()->can('promo_edit')) {
                            $retAction .= '<a href="' . route('admin.promo.get-menus', ['id' => $promo->id]) . '" class="btn btn-sm btn-icon float-left btn-success mr-2" data-toggle="tooltip" data-placement="top" title="Add Menu"> <i class="far fa-list-alt"></i></a>';
                        }
                        if (auth()->user()->can('promo_show')) {
                            $retAction .= '<a href="' . route('admin.promo.show', $promo) . '" class="btn btn-sm btn-icon float-left btn-info mr-2" data-toggle="tooltip" data-placement="top" title="View"> <i class="far fa-eye"></i></a>';
                        }

                        if (auth()->user()->can('promo_edit')) {
                            $retAction .= '<a href="' . route('admin.promo.edit', $promo) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="far fa-edit"></i></a>';
                        }

                        if (auth()->user()->can('promo_delete')) {
                            $retAction .= '<form class="float-left pl-2" action="' . route('admin.promo.destroy', $promo) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                        }
                    }
                    return $retAction;
                })
                ->editColumn('id', function ($promo) use (&$i) {
                    return ++$i;
                })
                ->editColumn('name', function ($promo) {
                    return $promo->name;
                })
                ->editColumn('from_date', function ($promo) {
                    return food_date_format($promo->from_date);
                })
                ->editColumn('to_date', function ($promo) {
                    return food_date_format($promo->to_date);
                })
                ->editColumn('status', function ($promo) {
                    return trans('statuses.' . $promo->status);
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.promo.index');
    }

    public function getMenus($id)
    {
        $menus = $this->promoService->getMenus($id);
        // echo "<pre>"; print_r($menus); die;
        return view('admin.promo.promoMenu', $menus);
    }

    public function saveMenus(Request $request)
    {
        $promo = $this->promoService->saveMenus($request);
        if ($promo) {
            return redirect(route('admin.promo.index'))->withSuccess('The data updated successfully.');
        }
    }
}

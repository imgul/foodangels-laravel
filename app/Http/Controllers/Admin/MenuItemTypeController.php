<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\MenuItemTypeRequest;
use App\Models\MenuItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;
use App\Libraries\MyString;

class MenuItemTypeController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Menu item type';
        $this->middleware(['permission:menu-items-type'])->only('index');
        $this->middleware(['permission:menu-items-type_create'])->only('create', 'store');
        $this->middleware(['permission:menu-items-type_edit'])->only('edit', 'update');
        $this->middleware(['permission:menu-items-type_delete'])->only('destroy');
        $this->middleware(['permission:menu-items-type_show'])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.menu-item-type.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.menu-item-type.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( MenuItemTypeRequest $request )
    {
        $menuItemType          = new MenuItemType;
        $menuItemType->name    = strip_tags($request->name);
        $menuItemType->status  = $request->status;
        $menuItemType->save();

        return redirect(route('admin.menu-items-type.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( $id )
    {
        $this->data['menuItemType'] = MenuItemType::where(['id' => $id])->first();

        return view('admin.menu-item-type.edit', $this->data);

    }

    /**
     * Update the specified resource in storage.
     * @param MenuItemTypeRequest $request
     * @param $id
     * @return mixed
     */
    public function update($id, MenuItemTypeRequest $request )
    {

        $menuItemType          = MenuItemType::findOrFail($id);
        $menuItemType->name    = strip_tags($request->name);
        $menuItemType->status  = $request->status;
        $menuItemType->save();
        return redirect(route('admin.menu-items-type.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $menuItemType = MenuItemType::where(['id' => $id])->first();
        if($menuItemType) {
            $menuItemType->delete();
            return redirect(route('admin.menu-items-type.index'))->withSuccess('The Data Deleted Successfully');
        }
    }

    public function getMenuItemType(Request $request)
    {

        if(request()->ajax()) {
            $menuItemTypes = MenuItemType::where('status',$request->status)->orderBy('id', 'DESC')->get();
            $i     = 0;
            return Datatables::of($menuItemTypes)->addColumn('action', function( $menuItemType ) {
                $retAction = '';
                if(auth()->user()->can('menu-items-type_edit')) {
                    $retAction .= '<a href="' . route('admin.menu-items-type.edit', $menuItemType) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                }
                if (auth()->user()->can('menu-items-type_delete')) {
                    $retAction .= '<form class="float-left pl-2" action="' . route('admin.menu-items-type.destroy', $menuItemType). '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })->editColumn('name', function( $menuItemType ) {
                return Str::limit($menuItemType->name, 50);
            })->editColumn('status', function( $menuItemType ) {
                return ($menuItemType->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
            })->editColumn('id', function( $menuItemType ) use ( &$i ) {
                return ++$i;
            })->rawColumns(['action'])->escapeColumns([])->make(true);
        }
    }
}

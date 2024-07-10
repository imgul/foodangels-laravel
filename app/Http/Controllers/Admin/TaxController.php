<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Tax;
use App\Models\Bank;

use App\Models\Branch; 
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\TaxRequest;
use App\Http\Requests\BankRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BackendController;

class TaxController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Tax';

        $this->middleware(['permission:tax'])->only('index');
        $this->middleware(['permission:tax_create'])->only('create', 'store');
        $this->middleware(['permission:tax_edit'])->only('edit', 'update');
        $this->middleware(['permission:tax_delete'])->only('destroy');
    }

    public function index()
    {
        $taxes = Tax::latest()->get();
        $this->data['taxes']     = $taxes;
        return view('admin.tax.index', $this->data);
    }

    public function create()
    {
        return view('admin.tax.create', $this->data);
    }


    public function store(TaxRequest $request)
    {
        $tax         = new Tax;
        $tax->label  = $request->label;
        $tax->rate   = $request->rate;
        $tax->status = $request->status;
        $tax->save();
        return redirect(route('admin.tax.index'))->withSuccess('The data inserted successfully.');
    }


    public function edit($id)
    {
        $this->data['tax'] = Tax::findOrFail($id);
        return view('admin.tax.edit', $this->data);
    }


    public function update(TaxRequest $request, Tax $tax)
    {
        $tax->label  = $request->label;
        $tax->rate   = $request->rate;
        $tax->status = $request->status;
        $tax->save();
        return redirect(route('admin.tax.index'))->withSuccess('The data updated successfully.');
    }

    public function show(Tax $tax)
    {
        return view('admin.tax.show', compact('tax'));
    }

    public function destroy($id)
    {
        Tax::findOrFail($id)->delete();
        return redirect(route('admin.tax.index'))->withSuccess('The data deleted successfully.');
    }

    public function getTax(Request $request)
    {
        if (request()->ajax()) {


            $auth = auth();
            $taxes = Tax::latest()->get();

            $i = 0;
            return Datatables::of($taxes)
                ->addColumn('action', function ($tax) {
                    $retAction = '';
                    if (auth()->user()->can('tax_edit')) {
                        $retAction .= '<a href="' . route('admin.tax.edit', $tax) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="far fa-edit"></i></a>';
                    }
                
                    if (auth()->user()->can('tax_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.tax.destroy', $tax) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                    }
                    return $retAction;
                })
                ->editColumn('id', function ($bank) use (&$i) {
                    return ++$i;
                })

                ->editColumn('label', function ($bank) {
                    return $bank->label;
                })

                ->editColumn('rate', function ($bank) {
                    return $bank->rate.'%';
                })

                ->editColumn('status', function ($bank) {
                    return trans('statuses.'.$bank->status);
                })

                ->escapeColumns([])
                ->make(true);
        }
    }
}

@extends('admin.layouts.master')


@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.promo') }}</h1>
        {{ Breadcrumbs::render('promo/show') }}
    </div>

    <div class="section-body">
        <div class="row "  id="printablediv">
            <div class="col-4 col-md-4 col-lg-4 p-2">
                <div class="card">
                    <div class="card-body card-profile">
                        <div class="d-flex align-items-center mb-3">
                            <img class="coupon-logo ml-5 mr-4" src="{{ asset("images/".setting('site_logo')) }}" alt="">
                            <h3 class="text-center mb-3 text-warning font-weight-bold">{{ $promo->name }}</h3>
                        </div>

                        <ul class="list-group">
                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.name') }}</span>
                                <span class="float-right">{{ $promo->name }}</span>
                            </li>

                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.discount') }}</span>
                                <span class="float-right">{{$promo->amount."%"}}</span>
                            </li>

                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.starts_at') }}</span>
                                <span class="float-right">{{ date('h:i A , d F Y',strtotime($promo->from_date)) }}</span>
                            </li>

                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.ends_at') }}</span>
                                <span class="float-right">{{ date('h:i A , d F Y',strtotime($promo->to_date)) }}</span>
                            </li>

                            <li class="list-group-item profile-list-group-item">
                                <span class="float-left font-weight-bold">{{ __('levels.status') }}</span>
                                <span class="float-right">{{ trans('statuses.'.$promo->status) }}</span>
                            </li>


                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-8 col-md-8 col-lg-8 p-2">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th colspan="2">#</th>
                            <th colspan="2">{{__('levels.branch_name')}}</th>
                            <th colspan="2">{{__('menu.menu_items')}}</th>
                            <th colspan="2">{{__('levels.price')}}</th>
                            <th colspan="2">{{__('levels.after_discount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!blank($menus))
                        @foreach($menus as $menu)
                        <tr class="text-center">
                            <td colspan="2" >
                                {{ $loop->index }}
                            </td>
                            <td colspan="2" >
                                {{ Str::limit($menu->branch->name,10)}}
                            </td>
                            <td colspan="2" >
                                {{ Str::limit($menu->name,10)}}
                            </td>
                            <td colspan="2" >
                                {{ currencyFormat($menu->unit_price - $menu->discount_price)  }}
                            </td>
                            <td colspan="2" >
                                {{ promoPrice($menu->unit_price,$menu->discount_price,$promo->amount) }}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="text-center mt-4" >
                            <td class="" colspan="12">
                                {{__('levels.no_items_addes')}}
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="">
        <button class="btn btn-success btn-md report-print-button" onclick="printDiv('printablediv')">{{ __('levels.print') }}</button>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/promo/index.js') }}"></script>
@endsection
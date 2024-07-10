@extends('admin.layouts.master')


@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.add_menus_to_promotion') }}</h1>
        {{ Breadcrumbs::render('promo/show') }} 
    </div>

    <div class="section-body">
        <div class="row">
            <div class=" col-md-10 offset-md-1 p-2">
                <div class="d-flex rounded justify-content-between mb-3 bg-warning py-1 px-4">
                    <h3 class="text-dark m-0">{{ $promo->name}}</h3>
                    <h3 class="text-light m-0">{{ $promo->amount }}%</h3>
                </div>
                <form action="{{ route('admin.promo-menu-store') }}" method="POST">
                    @csrf
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>{{ __('#') }}</th>
                                <th>{{ __('levels.menu_name') }}</th>
                                <th>{{ __('levels.price') }}</th>
                                <th>{{ __('levels.after_discount') }}</th>

                            </tr>
                        </thead>

                        <tbody id="menu-list">
                            <input type="hidden" value="{{$promoID}}" name="promo_id">
                            @if(!blank($allMenus))
                            @foreach($allMenus as $menu)
                            <tr>
                                <td>
                                    <input {{ array_key_exists($menu->id,$oldMenus) ? "checked" : "" }} type="checkbox"
                                        name="menus[<?= $menu->id ?>]" value="{{$menu->id}}" />
                                </td>
                                <td>
                                    <label>{{$menu->name}}</label>
                                </td>
                                <td>
                                    <label>{{currencyFormat($menu->unit_price - $menu->discount_price)}}</label>
                                </td>
                                <td>
                                    <label> {{ promoPrice($menu->unit_price,$menu->discount_price,$promo->amount) }}
                                    </label>
                                </td>

                            </tr>
                            @endforeach
                            @else
                            <tr>{{__('levels.no_items_available')}}</tr>
                            @endif
                        </tbody>
                    </table>
                    <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

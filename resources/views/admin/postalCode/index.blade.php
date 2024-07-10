@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header d-block">
        <h1 class="d-flex justify-content-between">
            <span>{{ $restaurant->name }}</span>
            <span>{{ __('levels.postalCode') }}</span>
        </h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @can('bank_create')
                         <a href="{{ route('admin.postalCode.create',$restaurant->id) }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('levels.add_postalCode') }}</a>
                        @endcan
                            <a href="{{ route('admin.restaurants.index') }}" class=" btn btn-icon btn-danger" style="margin-left: 75%"><i class="fa fa-arrow-left"></i> {{ __('levels.back') }}</a>
                    </div>
                    <input type="hidden" name="restaurantID" value="{{$restaurant->id}}" id="restaurantID">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable" data-resturant_Id="{{$restaurant->id}}" data-url="{{ route('admin.get-postalCode') }}">
                                <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.postal_code') }}</th>
                                        <th>{{ __('levels.delivery_charge') }}</th>
                                        <th>{{ __('restaurant.delivery_time') }}</th>
                                        <th>{{ __('restaurant.min_order') }}</th>
                                        <th>{{ __('restaurant.max_order') }}</th>
                                        <th>{{ __('levels.actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/postalCode/index.js') }}"></script>
@endsection

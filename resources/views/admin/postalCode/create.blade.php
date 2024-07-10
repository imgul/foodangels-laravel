@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header d-block">
        <h1 class="d-flex justify-content-between">
            <span>{{ __('levels.postalCode') }} / {{ __('levels.add') }}</span>
            <span>{{ $restaurant->name }}</span>
        </h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.postalCode.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <input type="hidden" name="restaurant_id" id="restaurant_id" value="{{ $restaurant->id}}">
                                <div class="form-group col-lg-6">
                                    <label>{{ __('levels.postal_code') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" value="{{ old('postal_code') }}">
                                    @error('postal_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('levels.delivery_charge') }}</label><span class="text-danger">*</span>
                                    <input type="text" name="delivery_charge" class="form-control @error('delivery_charge') is-invalid @enderror" value="{{ old('delivery_charge') }}">
                                    @error('delivery_charge')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('restaurant.delivery_time') }}</label><span class="text-danger">*</span>
                                    <input type="text" name="delivery_time" class="form-control @error('delivery_time') is-invalid @enderror" value="{{ old('delivery_time') }}">
                                    @error('delivery_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('restaurant.min_order') }}</label><span class="text-danger">*</span>
                                    <input type="text" name="min_order" class="form-control @error('min_order') is-invalid @enderror" value="{{ old('min_order') }}">
                                    @error('min_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>{{ __('restaurant.max_order') }}</label><span class="text-danger">*</span>
                                    <input type="text" name="max_order" class="form-control @error('max_order') is-invalid @enderror" value="{{ old('max_order') }}">
                                    @error('max_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/phone_validation/index.js') }}"></script>
<script src="{{ asset('js/bank/create.js') }}"></script>
@endsection

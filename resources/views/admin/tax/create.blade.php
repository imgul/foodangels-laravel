@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('levels.tax') }}</h1>
        {{-- {{ Breadcrumbs::render('tax/add') }} --}}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.tax.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">

                                <div class="form-group col-lg-6">
                                    <label>{{ __('levels.label') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label') }}">
                                    @error('label')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">

                                    <label for="rate">{{__("levels.rate")}}</label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input name="rate" id="rate" type="text" class="form-control @error('rate') is-invalid @enderror" value="{{ old('rate') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    @error('rate')
                                    <div class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror

                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(trans('statuses') as $key => $status)
                                        <option value="{{ $key }}" {{ (old('status') == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
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
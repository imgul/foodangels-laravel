@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('levels.request_withdraw') }}</h1>
            {{ Breadcrumbs::render('request-withdraw/edit') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <form action="{{ route('admin.request-withdraw.update', $requestwithdraw) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if (auth()->user()->myrole == 1)
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label>{{ __('levels.user') }}</label> <span class="text-danger">*</span>
                                            <select name="user_id" id="user_id"
                                                class="form-control select2 @error('user_id') is-invalid @enderror"
                                                data-url="{{ route('admin.request-withdraw.get-user-info') }}">
                                                <option value="">{{ __('levels.select_user') }}</option>
                                                <?php $selectUser = []; ?>
                                                @if (!blank($users))
                                                    @foreach ($users as $user)
                                                        @if ($user->id == old('user_id'))
                                                            <?php $selectUser = $user; ?>
                                                        @endif
                                                        <option {{ $user->id == $requestwithdraw->user_id ? 'selected' : '' }}
                                                            value={{ $user->id }}>{{ $user->name }} (
                                                            {{ trans('user_roles.' . $user->myrole) }} )</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}"
                                        data-url="{{ route('admin.request-withdraw.get-user-info') }}">


                                @endif
                                <div class="form-group">
                                    <label>{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="amount"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        value="{{ old('amount', $requestwithdraw->amount) }}">
                                    @error('amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('levels.date') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="date" class="form-control datepicker @error('date') is-invalid @enderror"
                                    value="{{ old('date', date('Y-m-d', strtotime($requestwithdraw->date))) }}">

                                    @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>


                                @if (auth()->user()->myrole == 1)
                                    <div class="form-group">
                                        <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            @foreach (trans('request_withdraw_statuses') as $key => $status)
                                                @if ($key != \App\Enums\RequestWithdrawStatus::COMPLETED)
                                                    <option value="{{ $key }}"
                                                        {{ old('status', $requestwithdraw->status) == $key ? 'selected' : '' }}>
                                                        {{ $status }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="userInfo" class="col-12 col-md-12 col-lg-4">


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
    <script src="{{ asset('js/requestwithdraw/create.js') }}"></script>
@endsection

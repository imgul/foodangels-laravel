@extends('frontend.layouts.app')
@section('main-content')
    <!--======= LOGIN PART START ========-->
    <section class="auth">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-7">
                    <div class="auth-content">
                        <nav class="auth-navs">
                            <a class="nav-link active" href="{{ route('login') }}"> {{ __('frontend.login') }} </a>
                            <a class="nav-link" href="{{ route('register') }}"> {{ __('frontend.register') }}</a>
                        </nav>
                        <div class="auth-tabs">
                            <div class="auth-header">
                                <h3>{{ __('frontend.welcome_back') }}</h3>
                                <p> {{ __('frontend.please_enter_login_details') }}</p>
                            </div>
                            <form method="POST" class="login" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="type" value="frontend">

                                <div class="form-group">
                                    <label for="email" class="form-label"> {{ __('frontend.email') }} </label>
                                    <input id="demoemail" type="email"
                                        class="form-control  @if ($errors->has('email') || session('block')) is-invalid @endif"
                                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                                        placeholder="{{ __('frontend.email') }}">
                                    <small
                                        class="form-alert red">{{ __("frontend.email_privacy") }}</small>

                                    @if ($errors->has('email'))
                                        <span class="is-invalid" role="alert">
                                            <strong class="text-danger">{{ $errors->first('frontend.email') }}</strong>
                                        </span>
                                    @elseif(session('block'))
                                        <span class="is-invalid" role="alert">
                                            <strong>{{ session('block') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="password">{{ __('frontend.password') }}:</label>
                                    <input placeholder="{{ __('frontend.password') }}" id="demopassword" type="password"
                                        class="form-control @if ($errors->has('password')) is-invalid @endif"
                                        name="password" autocomplete="current-password">
                                    @if ($errors->has('password'))
                                        <span class="is-invalid" role="alert">
                                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="d-flex justify-content-between">
                                    <div class="form-group form-check-group">
                                        <input type="checkbox" id="remember-me" name="check">
                                        <label for="remember-me"> {{ __('frontend.remember_me') }}</label>
                                    </div>

                                    <div class="col-md-6 d-flex justify-content-end">
                                        <label for="forgot password">
                                            <a class="linkTxt" href="{{ route('password.request') }}"
                                                class="text-primary">{{ __('frontend.forgot_password') }}</a>
                                        </label>
                                    </div>
                                </div>

                                <input type="submit" class="form-btn" value="{{ __('frontend.login') }}">

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <img class="auth-banner" src="{{ asset('frontend/images/auth.jpg') }}" alt="auth">
    </section>
    <!--======== LOGIN PART END ========-->
@endsection

@push('js')
@endpush

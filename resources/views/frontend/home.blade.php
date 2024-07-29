@extends('frontend.layouts.app')
@push('meta')
    <meta property="og:url" content="{{ route('home') }}" />
    <meta property="og:type" content="FoodBank" />
    <meta property="og:title" content="{{ setting('banner_title') }}">
    <meta property="og:description" content="Explore top-rated attractions, activities and more">
    <meta property="og:image" content="{{ asset('images/' . setting('site_logo')) }}">
@endpush

@push('css')
    <style>
        @media only screen and (max-width: 600px) {
            .pac-container.pac-logo.hdpi {
                width: calc(100vw - 80px) !important;
            }
        }
    </style>
@endpush

@section('main-content')

    <!--======== BANNER PART START ==========-->
    <div class="color-overlay"></div>

        <section class="banner py-0" data-background-image="{{ asset('frontend/images/default/Veganer-Halal-Ttiple1-Burger-Foodangels-Vegan.jpg') }}" style="background-repeat: no-repeat; background-size: cover; background-position: center; background-image: url({{ asset('frontend/images/default/Veganer-Halal-Ttiple1-Burger-Foodangels-Vegan.jpg') }}); height: calc(100vh - 70px); display: flex; align-items: center;">
            <div id="overlay">
                <div class="container h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-12 col-md-7 col-lg-6">

                            <h1 class="banner-title"> {{ Str::limit(setting('banner_title'), 75) }} </h1>

                            <p class="banner-subtitle mb-5"> {{ __('frontend.subtitle') }} </p>
                            <form id="search-form"  method="GET" action="{{ route('search') }}">
                                <div class="main-search-input">
                                    <input type="hidden" id="lat" name="lat" required="" value="">
                                    <input type="hidden" id="long" name="long" required="" value="">
                                    <input type="hidden" id="expedition" name="expedition" value="{{ __('all') }}">

                                    <div class="banner-search main-search-input-item location">
                                        <div id="autocomplete-container" class="me-auto ms-2 w-100">
                                            <input id="autocomplete-input" type="text" placeholder="{{ __('frontend.search') }}" name="s">

                                        </div>
                                        <a href="javascript:void(0)">
                                            <span id="locationIcon" onclick="getLocation()">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 19.5C16.1421 19.5 19.5 16.1421 19.5 12C19.5 7.85786 16.1421 4.5 12 4.5C7.85786 4.5 4.5 7.85786 4.5 12C4.5 16.1421 7.85786 19.5 12 19.5Z"
                                                        stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                                                        stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M12 4V2" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M4 12H2" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M12 20V22" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M20 12H22" stroke="#EE1D48" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="d-flex gap-1">
                                            <!-- <button id="searchBtn" type="submit">{{ __('frontend.search') }}</button> -->
                                            <button id="pickupBtn" class="button">{{ __('frontend.pickup') }}</button>
                                        </div>
                                    </div>
                                    @error('s')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </form>
        {{--                    <form id="form2" method="GET" action="{{ route('filters') }}" class="pickup-from-frm">--}}
        {{--                        <input type="hidden" id="restaurant" name="restaurant"  value="{{$restaurant->slug}}">--}}
        {{--                    </form>--}}
                        </div>

                        <div class="col-12 col-md-5 col-lg-6">
                            <div class="banner-image">
        {{--                        <img src="{{ asset('images/' . setting('banner_image')) }}"--}}
        {{--                            alt="hero">--}}


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!--======== BANNER PART END ========-->

    <!--========  AWESOME STUFF START ========-->
    <div class="section_1">
        <div class="container">
            <div class="row no-margin-row justify-content-between align-items-center">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="main-text-area">
                        <h4>{{ __('Awesome Stuff') }}</h4>
                        <h2>{{ __('New with us: The Italian Burger') }} </h2>
                        <p>{{ __('Best beef with tomato, mozzarella, rocket, basil, balsamic cream, and our brilliant, homemade aioli dip. Definitely worth a try!') }} </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-5">
                    <div class="main-image">
                        <img src="/frontend/images/default/homepage-bild-86-kbs.jpg" height="400px" alt="" >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======== AWESOME STUFF END ========-->

    <!--========  ADVANCE ORDER START ========-->
    <div class="section_advanceorder">
        <div class="container-fluid">
            <div class="row no-margin-row justify-content-between align-items-center">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="opening_details">
                        <h4>{{ __('Pre-order or just drop by') }} </h4>
                        <h2>{{ __('Opening Hours') }} </h2>
                        <div class="dotts">....</div>
                        <div class="work-time">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3>{{ __('Monday') }} - {{ __('Friday') }}</h3>
                                    <div class="hours">
                                        {{ date('H:i', strtotime($restaurant->week_days_opening)) }} <br>
                                        {{ date('H:i', strtotime($restaurant->week_days_closing)) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h3>{{ __('Saturday') }} - {{ __('Sunday') }}</h3>
                                    <div class="hours">
                                        {{ date('H:i', strtotime($restaurant->weekend_opening)) }} <br>
                                        {{ date('H:i', strtotime($restaurant->weekend_closing)) }}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="bold-separator"><div class="dotts">.</div></div>
                        <a class="call"href="tel:022116818938">022116818938 </a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="bg-image" style="background-image: url('/frontend/images/default/PXL-02.jpg');">
                        <p>{{ __('Our burger trailer may be small, but it\'s mighty. All our burgers are prepared fresh, right before your eyes. We only use the finest 100% beef and fresh vegetables from the region.') }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======== ADVANCE ORDER END ========-->

    <!--========  MADE WITH LOVE START ========-->
    <div class="section_1">
        <div class="container">
            <div class="row no-margin-row justify-content-between align-items-center">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="main-text-area">
                        <h4>{{ __('Made with Love') }}</h4>
                        <h2>{{ __('Small shop, great burgers!') }} </h2>
                        <p>{{ __('Our burger trailer may be small, but it\'s mighty. All our burgers are prepared fresh, right before your eyes. We only use the finest 100% beef and fresh vegetables from the region. Plus, you can enjoy our homemade burger sauces and mayonnaises.') }}</p>
                        <p>{{ __('FoodAngels: Freestyle, hausgemachte Gerichte mit frischen, gesunden Zutaten, ohne Geschmacksverstärker oder Chemie. Vegan, halal, vegetarisch - für jeden Geschmack das Richtige! - slightly crispy on the outside, soft on the inside.') }} </p>
                        <p>{{ __('Your burger shop in Cologne') }} </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-5">
                    <div class="main-image">
                        <img src="/frontend/images/default/PXL-01.jpg" height="700" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--======== MADE WITH LOVE END ========-->

    <!--========= Cusines PART START ========-->
{{--    @if (!blank($bestSellingCuisines))--}}
{{--        <section class="category section-gap-66">--}}
{{--            <div class="container">--}}
{{--                <h2 class="section-title borderd">{{ __('frontend.popular_cuisines') }} </h2>--}}
{{--                <div class="row">--}}

{{--                    @foreach ($bestSellingCuisines as $key => $bestSellingCusine)--}}
{{--                        <div class="col-6 col-md-4 col-lg-3">--}}
{{--                            <a href="{{ route('search', ['cuisines' => [$bestSellingCusine->slug], 'expedition' => 'all']) }}"--}}
{{--                                class="category-card">--}}
{{--                                <img class="bestSellingCusineImage" src="{{ $bestSellingCusine->image }}"--}}
{{--                                    alt="category">--}}

{{--                                <h4> {{ Str::of(strip_tags($bestSellingCusine->name))->limit(18) }}</h4>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    @endif--}}
    <!--========== Cusines PART END =========-->
    @include('frontend.partials._cookies')
@endsection

@push('js')
    <script type="text/javascript" src="{{ asset('frontend/js/map-current.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ setting('google_map_api_key') }}&sensor=false&libraries=places&callback=initAutocomplete">
    </script>


<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>




<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const beep = document.getElementById("myAudio1");

        function sound() {
            beep.play();
        }
        // web_token
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "{{ setting('firebase_api_key') }}",
                 authDomain: "{{ setting('firebase_authDomain') }}",
                 projectId:"{{ setting('projectId') }}",
                storageBucket:"{{ setting('storageBucket') }}",
                 messagingSenderId: "{{ setting('messagingSenderId') }}",
                 appId: "{{ setting('appId') }}",
                 measurementId: "{{ setting('measurementId') }}",
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        startFCM();

        function startFCM() {
            messaging.requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    $.ajax({
                        url: '{{ route('store.token') }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            //console.log(response);
                        },
                        error: function(error) {
                            //console.log(error);
                        },
                    });

                }).catch(function(error) {});
        }
        messaging.onMessage(function(payload) {
            //console.log(payload);
            const title = payload.data.title;
            const body = payload.data.body;

            sound();
            $('#custom-width-modal').modal('show');
            $('#notificationTitle').text(title);
            $('#notificationBody').text(body);


            new Notification(title, {
                body: body,
            });
        });

    });
</script>

<script>
    let searchForm = document.querySelector("#search-form");
    let pickupBtn = document.querySelector("#pickupBtn");
    pickupBtn.addEventListener('click', (e) => {
        e.preventDefault();
        localStorage.setItem('is-pickup', '1');
        searchForm.submit();
    });

    let searchBtn = document.querySelector("#searchBtn");
    searchBtn.addEventListener('click', (e) => {
        e.preventDefault();
        localStorage.setItem('is-pickup', '0');
        searchForm.submit();
    });
</script>


@endpush

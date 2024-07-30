@extends('frontend.layouts.restaurent_app')
@push('meta')
    <meta property="og:url" content="{{ route('restaurant.show', [$restaurant->slug]) }}" />
    <meta property="og:type" content="{{ setting('site_name') }}">
    <meta property="og:title" content="{{ $restaurant->name }}">
    <meta property="og:description" content="{{ $restaurant->description }}">
    <meta property="og:image" content="{{ $restaurant->image }}">

    <style>
        .section_advanceorder {
            background: unset !important;
        }

        .button.primary-button {
            -ms-flex-negative: 0;
            flex-shrink: 0;
            font-size: 22px;
            font-weight: 500;
            line-height: 34px;
            border-radius: 25px;
            padding: 7px 24px;
            cursor: pointer;
            text-transform: capitalize;
            color: var(--white);
            background-color: var(--primary);
        }
    </style>
@endpush

@push('body-data')
    data-bs-spy="scroll" data-bs-target="#scrollspy-menu" data-bs-smooth-scroll="true"
@endpush

@section('main-content')

    <!--====== RESTAURANT PART START =========-->
    <section class="restaurant">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12 rest-col">
                    <div class="rest-content">
                        <div class="section_advanceorder page" style="margin-top: 60px;">
                            <div class="container">
                                <div class="row no-margin-row justify-content-between">
                                    <div class="col-sm-12 col-md-4 col-lg-4" style="background-color: #d4eecc !important;">
{{--                                        <div class="rest-logo">--}}
{{--                                            <img src="{{ $restaurant->image }}" alt="logo">--}}
{{--                                        </div>--}}
                                        <div class="rest-name">
                                            <h6 class="text-danger">{{ __('frontend.closed_restaurant_message') }}</h6>
                                        </div>
                                        <div class="rest-name">
                                            <h3>{{ $restaurant->name }}</h3>
                                        </div>
                                        <div class="rest-address">
                                            <p>{{ $restaurant->address }}</p>
                                        </div>
                                        <div class="rest-input d-flex flex-column gap-4 align-items-center">
                                            <!-- dropdown to select the restaurant's available time slots from $slots -->
                                            <select id="time_slot" name="time_slot" class="form-control form-control-sm">
                                                <option>{{ __('frontend.select_time_slots_for_tomorrow') }}</option>
                                                @foreach ($timeSlots as $slot)
                                                    <option value="{{ $slot }}">{{ $slot }}</option>
                                                @endforeach
                                            </select>
                                            <button id="orderLaterBtn" class="button primary-button" style="background-color: #ba5dba;">Wähle Zeit+Go</button>
                                        </div>
                                        <div class="bold-separator"><div class="dotts">.</div></div>
                                        <div class="contact_details">
                                            <a href="tel:022116818938"><i class="fa fa-phone" aria-hidden="true"></i>022116818938 </a>
                                            <a href="https://wa.me/+4901781422310"><i class="fa fa-whatsapp" aria-hidden="true"></i>01781422310</a>
                                        </div>
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2512.0697361670505!2d6.9326509!3d50.977901599999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47bf2f63eea9f1bb%3A0xe7639c568387a241!2sFoodangels%20Burger%20%26%20Pizza%20-%20Vegan%20%26%20Halal%20-%20Lieferservice%20K%C3%B6ln!5e0!3m2!1sen!2sin!4v1713788377847!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-lg-8" style="background: #1a1938;">
                                        <div class="work-time">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h3>{{ __('frontend.monday') }} - {{ __('frontend.friday') }}</h3>
                                                    <div class="fs-3 text-white"> {{ date('H:i', strtotime($restaurant->week_days_opening)) }} <br>
                                                        {{ date('H:i', strtotime($restaurant->week_days_closing)) }} </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h3>{{ __('frontend.saturday') }} - {{ __('frontend.sunday') }}</h3>
                                                    <div class="fs-3 text-white">{{ date('H:i', strtotime($restaurant->weekend_opening)) }} <br>
                                                        {{ date('H:i', strtotime($restaurant->weekend_closing)) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($featured))
                                            <div class="new_items">
                                                    <?php
                                                    //   echo "<pre>"; print_r($featured[0]->image); die;
                                                    ?>
                                                @foreach($featured as $menu)

                                                    <div class="items_list">
                                                        <img class="new_tag" src="{{asset('frontend/images/default/new.png')}}" alt="">
                                                        <img class="new_product" src="{{ isset($menu->image) ? $menu->image : asset('frontend/images/default/Italian-Burger.jpg') }}" alt="">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('frontend.partials._footer')
                </div>
            </div>
        </div>
    </section>
    <!--=======  RESTAURANT PART END ========-->

@endsection

@push('js')
    <script> const reservationUrl = "{{ route('reservation.check') }}";</script>
    <script src="{{ asset('frontend/js/booking.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/show.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/loader.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/navcount.js') }}" type="text/javascript"></script>
    <script>
        let orderLaterBtn = document.getElementById('orderLaterBtn');
        orderLaterBtn.addEventListener('click', function() {
            let timeSlot = document.getElementById('time_slot').value;
            window.location.href = "{{ route('restaurant.show', [$restaurant->slug]) }}?time_slot=" + timeSlot;
        });
    </script>
@endpush

@push('livewire')
    <script src="{{ asset('js/order-cart.js') }}"></script>
@endpush

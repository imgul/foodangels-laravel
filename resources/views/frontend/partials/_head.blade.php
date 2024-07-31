<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AUTHOR -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @stack('meta')

    <!-- WEBPAGE TITLE -->
    <title>
        @if (isset($site_title) && setting('site_name'))
            {{ setting('site_name') . ' : ' . $site_title }}
        @elseif(setting('site_name'))
            {{ setting('site_name') }}
        @elseif($site_title)
            {{ $site_title }}
        @else
            {{ '' }}
        @endif
    </title>

    <!-- FAVICON -->
    <link href="{{ asset('images/' . setting('fav_icon')) }}" rel="shortcut icon" type="image/x-icon">

    <!-- LIBRARY -->
{{--    <link rel="stylesheet" href="{{ asset('frontend/lib/swiper/swiper-bundle.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('frontend/lib/bootstrap/bootstrap.min.css') }}">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.1.0/swiper-bundle.min.css" integrity="sha512-n/86mxSdfFpsFtq9QYVhRlke9BQ/ZqIaRBe/dboH4l8JwBVitjpCS2HnDfbZnISV5Zq1lKONL/aQDqDQmtY/cA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css" integrity="sha512-72OVeAaPeV8n3BdZj7hOkaPSEk/uwpDkaGyP4W2jSzAC8tfiO4LMEDWoL3uFp5mcZu+8Eehb4GhZWFwvrss69Q==" crossorigin="anonymous" referrerpolicy="no-referrer" defer />

    <!-- FONTS -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/lineicons/lineicons.min.css') }}" defer>
    <link rel="stylesheet" href="{{ asset('frontend/fonts/fontawesome/fontawesome.min.css') }}" defer>
    <link rel="stylesheet" href="{{ asset('frontend/fonts/opensauce/opensauce.min.css') }}" defer>

    <!-- iziToast -->
{{--    <link rel="stylesheet" href="{{ asset('assets/modules/izitoast/dist/css/iziToast.min.css') }}">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" defer/>

    <!-- CUSTOM -->
    <link rel="stylesheet" href="{{ asset('frontend/css/expanded/style.css') }}" defer>

    <!-- My Custom Css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/expanded/delopovercustom.css') }}" defer>
    <link rel="stylesheet" href="{{ asset('frontend/css/expanded/old.css') }}" defer>


    @stack('style')

    @livewireStyles
</head>

 <div style="display: none;" id="cookieNotice" class="ps-fixed cookies-w">
     <p class="fs-body2 fw-bold mb4 mt-2 text-white fs-4 mb-1">
         {{ __('frontend.your_privacy') }}
     </p>
     <p class="cookies_title text-white">
         {{ __('frontend.cookies_title') }}
     </p>
      <p class="cookies_title_phone text-white d-none">
        {{ __('frontend.cookies_title_phone') }}
    </p>
     <div class="d-flex cookies-parent">
         <button onclick="acceptCookieConsent()" class=" text-center flex--item s-btn btn btn-primary js-accept-cookies js-consent-banner-hide cookies-border">
             {{ __('frontend.accept_all_cookies') }}
         </button>
         {{-- </div> --}}
         {{-- <div class=""> --}}
         <button onclick="cancel()" class="ml-2 text-center flex--item s-btn btn btn-danger js-accept-cookies js-consent-banner-hide cookies-border" >
             {{ __('frontend.cookies_cancel') }}
         </button>
     </div>
     <div class="d-flex text-light justify-content-center">
         @if(!blank($pages))
         @foreach($pages as $page)
         @if($page->footer_menu_section_id == \App\Enums\FooterMenuSection::COOKIES_DETAILS)
         <a class="cookies-info " target="_blank" href="{{ route('page', $page->slug) }}">{{ $page->title }}</a>
         @elseif($page->footer_menu_section_id == \App\Enums\FooterMenuSection::DATA_PROTECTION)
         <a class="cookies-info  mx-5" target="_blank" href="{{ route('page', $page->slug) }}">{{ $page->title}}</a>
         @elseif($page->footer_menu_section_id == \App\Enums\FooterMenuSection::IMPRINT)
         <a class="cookies-info " target="_blank" href="{{ route('page', $page->slug) }}">{{ $page->title }}</a>
         @endif
         @endforeach
         @endif
     </div>
 </div>

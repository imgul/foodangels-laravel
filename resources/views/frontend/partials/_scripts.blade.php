    <!--========= JS LINK PART START =====-->
{{--    <script src="{{ asset('frontend/lib/jquery-3.5.0.min.js') }}"></script>--}}
{{--    <script src="{{ asset('frontend/lib/bootstrap/bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ asset('frontend/lib/swiper/swiper-bundle.min.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" defer integrity="sha512-k2WPPrSgRFI6cTaHHhJdc8kAXaRM4JBFEDo1pPGGlYiOyv4vnA0Pp0G5XMYYxgAPmtmv/IIaQA6n5fLAyJaFMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.min.js" defer integrity="sha512-eHx4nbBTkIr2i0m9SANm/cczPESd0DUEcfl84JpIuutE6oDxPhXvskMR08Wmvmfx5wUpVjlWdi82G5YLvqqJdA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.1.0/swiper-bundle.min.js" defer integrity="sha512-sR63/L3Slqn0OWMMafv7gmRGxkYJOcfgdN3jznwea9NYiett6R+cGdZ0t0TRHeH1gZogMyLE1oQpQ0Lc6ULKbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('frontend/lib/swiper/swiper-initialize.js') }}" defer></script>


    <!-- For Toster Notifications -->
{{--    <script src="{{ asset('assets/modules/izitoast/dist/js/iziToast.min.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" defer integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @stack('js')

    <!-- custom javascript -->
    <script type="application/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script type="text/javascript">
        @if (session('success'))
            iziToast.success({
                title: 'Success',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        @endif

        @if (session('error'))
            iziToast.error({
                title: 'Error',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        @endif

        @if (session('warning'))
            iziToast.error({
                title: 'Warning',
                message: '{{ session('warning') }}',
                position: 'topRight'
            });
        @endif
    </script>


<script>
        // Create cookie
        function setCookie(cname, cvalue,userIP, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            document.cookie = 'userIP' + "=" + userIP + ";" + expires + ";path=/";
        }

        // Delete cookie
        function deleteCookie(cname) {
            const d = new Date();
            d.setTime(d.getTime() + (24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=;" + expires + ";path=/";
        }
        // Set cookie consent
        function acceptCookieConsent(){
            deleteCookie('user_cookie_consent');
            deleteCookie('userIP');
            $.ajax({
                type : 'GET',
                url : '{{route('cookies-set')}}',
                dataType: 'json',
                success : function (data) {
                    setCookie('user_cookie_consent', data.userAgent,data.userIP, 30);
                    document.getElementById("cookieNotice").style.display = "none";
                },
                error:function(data){
                    console.log(data);
                }
            });
            $("body").removeClass("hide-body");
        }

        function cancel(){
            deleteCookie('user_cookie_consent');
            deleteCookie('userIP');
            $.ajax({
                type : 'GET',
                url : '{{route('cookies-cancel')}}',
                dataType: 'json',
                success : function (data) {
                    setCookie('user_cookie_consent', data.userAgent,data.userIP, 30);
                    document.getElementById("cookieNotice").style.display = "none";
                },
                error:function(data){
                    console.log(data);
                }
            });
            $("body").removeClass("hide-body");
        }
        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        let cookie_consent = getCookie("user_cookie_consent");
        if(cookie_consent != ""){
            document.getElementById("cookieNotice").style.display = "none";
        }else{
            if (document.getElementById("cookieNotice")) {
                document.getElementById("cookieNotice").style.display = "block";
            }
        }
    </script>

    @livewireScripts

    @stack('livewire')


    <!-- App custom js -->
    <script src="{{ asset('frontend/js/script.js') }}" ></script>
    <!--========= JS LINK PART END ==========-->

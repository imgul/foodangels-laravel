<!DOCTYPE html>
<html lang="de">
@include('frontend.partials._head')

<body @stack('body-data')>

    <div id="main-wrapper">
        @include('frontend.partials._nav')

        @yield('main-content')
        @includeUnless(request()->is(['login', 'register']), 'frontend.partials._footer')

    </div>
    @include('frontend.partials._scripts')

    <div class="alert alert-success alert-dismissible" id="alert-box" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" onclick="this.parentElement.style.display='none';">&times;</button>
        <strong>Success!</strong> <span id="message">Indicates a successful or positive action.</span>
    </div>

    <script>
        function showAlert(content, type) {

            var $notification = $('#alert-box');

            if (type === 'success') {
                $notification.removeClass('alert-danger alert-info').addClass('alert-success');
            } else if (type === 'error') {
                $notification.removeClass('alert-success alert-info').addClass('alert-danger');
            } else if (type == 'info') {
                $notification.removeClass('alert-success alert-danger').addClass('alert-info');
            }
            $('#message').text(content);
            $notification.fadeIn(1000);
        }
    </script>

</body>

</html>
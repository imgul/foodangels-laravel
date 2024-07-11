<!DOCTYPE html>
<html>
@include('frontend.partials._head')

<body @stack('body-data')>

    <div id="main-wrapper">
        @include('frontend.partials._nav')

        @yield('main-content')



    </div>

    <div class="alert alert-danger alert-dismissible" id="alert-box" style="display: none;">
        <button type="button" class="close" data-dismiss="alert" onclick="this.parentElement.style.display='none';">&times;</button>
        <strong>Error!</strong> <span id="error-message">Indicates a successful or positive action.</span>
    </div>

    <script>
        function showError(content) {
            $('#error-message').text(content);
            $('#alert-box').fadeIn(1000);
            return false;
        }
    </script>


    @include('frontend.partials._scripts')


</body>

</html>
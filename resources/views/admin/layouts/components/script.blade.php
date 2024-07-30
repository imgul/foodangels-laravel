<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery/dist/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/modules/popper.js/dist/popper.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraries -->
<script src="{{ asset('assets/modules/izitoast/dist/js/iziToast.min.js') }}"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;
    // Replace with your Pusher app key and cluster
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.cluster') }}',
        encrypted: true
    });

    // Subscribe to the 'orders' channel
    const channel = pusher.subscribe('orders');

    // Bind to the 'OrderReceived' event
    {{--channel.bind('App\\Events\\OrderReceived', function(data) {--}}
    {{--    // Parse the stringified JSON data--}}
    {{--    const parsedData = JSON.parse(data);--}}
    {{--    const order = parsedData.order;--}}

    {{--    // Display notification in the admin panel--}}
    {{--    console.log(parsedData);--}}
    {{--    console.log(order);--}}
    {{--    console.log(order.id);--}}
    {{--    // open this in an iframe--}}
    {{--    var link = `{{ route('admin.orders.invoice', ${order.id}) }}`;--}}
    {{--    var iframe = document.createElement('iframe');--}}
    {{--    // add id to iframe--}}
    {{--    iframe.class = 'iframe-orders';--}}
    {{--    iframe.src = link;--}}
    {{--    document.body.appendChild(iframe);--}}
    {{--    // Play a sound--}}
    {{--    var beep1 = new Audio('{{ asset("assets/audio/zomato_sms.mp3") }}');--}}
    {{--    beep1.play();--}}

    {{--    var audio1 = new Audio('{{ asset("assets/audio/new_order.mp3") }}');--}}
    {{--    setTimeout(function() {--}}
    {{--        audio1.play();--}}
    {{--    }, 3000);--}}
    {{--    // Show a toast notification--}}
    {{--    iziToast.show({--}}
    {{--        title: 'New Order',--}}
    {{--        message: 'You have a new order',--}}
    {{--        position: 'topRight'--}}
    {{--    });--}}
    {{--});--}}

    channel.bind('App\\Events\\OrderReceived', function(data) {
        // Parse the stringified JSON data
        const parsedData = JSON.parse(data);
        const order = parsedData.order;

        // Display notification in the admin panel
        console.log(parsedData);
        console.log(order);
        console.log(order.id);

        // Create a button to play the audio
        var playButton = document.createElement('button');
        playButton.textContent = 'Play Audio';
        document.body.appendChild(playButton);

// Add a click event listener to the button
        playButton.addEventListener('click', function() {
            // Play the audio when the button is clicked
            var beep1 = new Audio('{{ asset("assets/audio/zomato_sms.mp3") }}');
            beep1.play();

            var audio1 = new Audio('{{ asset("assets/audio/new_order.mp3") }}');
            setTimeout(function() {
                audio1.play();
            }, 3000);
        });

        // click on playButton to play audios automatically
        playButton.click();

        // Open in a new window (not iframe)
        var link = `{{ route('admin.orders.invoice', ['order' => '__ID__']) }}`;
        link = link.replace('__ID__', order.id);
        // window.open(link, '_blank');
        // open link in a detached separated window. no in ifram or new blank window
        var windowFeatures = 'width=400,height=600,location=no,toolbar=no,menubar=no';
        window.open(link, 'InvoiceWindow', windowFeatures);


        {{--// Play a sound--}}
        {{--var beep1 = new Audio('{{ asset("assets/audio/zomato_sms.mp3") }}');--}}
        {{--beep1.play();--}}

        {{--var audio1 = new Audio('{{ asset("assets/audio/new_order.mp3") }}');--}}
        {{--setTimeout(function() {--}}
        {{--    audio1.play();--}}
        {{--}, 3000);--}}

        // Show a toast notification
        iziToast.show({
            title: 'New Order',
            message: 'You have a new order',
            position: 'topRight'
        });
    });

    // // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;
    //
    // var pusher = new Pusher('759edb87b640b9700d98', {
    //     cluster: 'ap2'
    // });
    //
    // var channel = pusher.subscribe('orders');
    // channel.bind('App\\Events\\OrderReceived', function(data) {
    //     console.log(data);
    //     alert(JSON.stringify(data));
    // });
</script>
@yield('scripts')

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    @if(session('success'))
    iziToast.success({
        title: 'Success',
        message: '{{ session('success') }}',
        position: 'topRight'
    });
    @endif

    @if(session('error'))
    iziToast.error({
        title: 'Error',
        message: '{{ session('error') }}',
        position: 'topRight'
    });
    @endif

</script>
<script src="{{ asset('assets/js/comfirm-delete.js') }}"></script>

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
                        },
                        error: function(error) {
                        },
                    });

                }).catch(function(error) {});
        }
        messaging.onMessage(function(payload) {
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


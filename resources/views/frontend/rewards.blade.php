@extends('frontend.layouts.app')

@section('main-content')

<div class="container my-5">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h1>Rewards</h1>
            <hr>
        </div>
        @foreach($rewards as $key)

        <div class="col-md-12">

            <div class="row">

                @foreach($key->menuItems as $menu)

                <div class="col-md-4">
                    <div class="rounded border p-3">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex">
                                <div> <img src="{{ $menu->image }}" alt="" width="100"></div>
                                <div class="ms-2">
                                    <h4>{{ $menu->name }}</h4>
                                    {!! $menu->description !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                @endforeach



            </div>

            <div class="row">
                <div class="col-md-12 d-flex">
                    <a class="btn btn-primary d-inline-block ms-auto" href="{{ route('redeem', $key->id) }}">Redeem</a>
                </div>
            </div>
        </div>


        @endforeach
    </div>

</div>

<script>
    function readNotification(notification_id, user_id, element) {

        $(element).parent().fadeOut(1000);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '{{ route("read.notification") }}',
            data: {
                push_notification_id: notification_id,
                customer_id: user_id

            },
            dataType: 'json',
            success: function(data) {

                if (data.status == 'success') {
                    showAlert('Notification read successfully', 'success');
                } else if (data.status == 'already_read') {
                    showAlert('Notification is already marked read', 'info');
                } else {
                    showAlert('Something went wrong', 'error');
                }
            }
        });
    }
</script>

@endsection
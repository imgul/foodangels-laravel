@extends('frontend.layouts.app')

@section('main-content')

<div class="container my-5">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h1>Notifications</h1>
            <hr>
        </div>
        @foreach($notifications as $key)
        <div class="col-md-4">
            <div class="rounded border p-3">
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <div> <i class="fa-regular fa-bell fa-3x"></i></div>
                        <div class="ms-2">
                            <h4>{{ $key->title }}</h4>
                            <p class="mb-0">{{ $key->description }}</p>
                        </div>
                    </div>
                    @if($key->reads->isEmpty())
                    <div>
                        <a href="javascript: void(0)" class="text-dark" onclick="readNotification('{{ $key->id }}', '{{ auth()->id() }}', this)"><i class="fa-regular fa-eye"></i></a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- item -->
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
                }else if(data.status == 'already_read') {
                    showAlert('Notification is already marked read', 'info');
                } else {
                    showAlert('Something went wrong', 'error');
                }
            }
        });
    }
</script>

@endsection
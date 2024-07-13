@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('setting.rewards') }}</h1>
        {{ Breadcrumbs::render('rewards') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                   
                    <div class="card-header d-flex justify-content-between">
                        <a href="{{ route('admin.rewards.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                class="fas fa-plus"></i> {{ __('setting.add_reward') }}</a>
                       
                    </div>
              

                    <div class="card-body">
                   
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable"
                                data-url="{{ route('admin.restaurant.get-restaurant') }}"
                                data-status="{{ \App\Enums\RestaurantStatus::ACTIVE }}"
                                data-hidecolumn="{{ auth()->user()->can('restaurants_show') ||auth()->user()->can('restaurants_edit') ||auth()->user()->can('restaurants_delete') }}">
                                <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.name') }}</th>
                                        <th>{{ __('levels.redeemed') }}</th>
                                        <th>{{ __('levels.actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($rewards as $key)
                                    <tr>
                                        <td>{{ $key->id }}</td>
                                        <td>{{ $key->user->first_name . ' '  .  $key->last_name }}</td>
                                        <td>{{ $key->redeemed == 1 ? 'Yes' : 'No' }}</td>
                                        <td><button class="btn btn-danger btn-sm removeBtn"><i class="fa fa-trash"></i></button> </div></td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection



@section('css')
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
@endsection

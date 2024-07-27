@extends('admin.setting.index')

@section('admin.setting.breadcrumbs')
{{ Breadcrumbs::render('redeem-setting') }}
@endsection

@section('admin.setting.layout')
<div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.setting.redeem') }}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Score Value <br> (Points to credit in customer's account per order)</label>
                        <input type="text" class="form-control" name="score_value" value="{{ $redeem_setting->score_value }}">
                        @error('score_value')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Reward Value <br> (Give reward when customer's Score reaches reward value)</label>
                        <input type="text" class="form-control" name="reward_value" value="{{ $redeem_setting->reward_value }}">
                        @error('reward_value')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Reward Menu Item<br> (Menu Item to give as a Reward)</label>
                        <select class="form-control" name="reward_menu_item_id">
                            <option value="">Select Menu Item</option>
                            @foreach($menu_items as $menu_item)
                            <option value="{{ $menu_item->id }}" {{ $redeem_setting->reward_menu_item_id == $menu_item->id ? 'selected' : '' }}>{{ $menu_item->name }}</option>
                            @endforeach
                        </select>
                        @error('reward_value')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Status <br> (If enabled, rewards are provided.)</label>
                        <select class="form-control" name="status">
                            <option value="">Select Status</option>
                            <option value="1" {{ $redeem_setting->status == 1 ? 'selected' : '' }}>Enable</option>
                            <option value="0" {{ $redeem_setting->status == 0 ? 'selected' : '' }}>Disable</option>
                        </select>
                        @error('reward_value')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="id" value="{{ $redeem_setting->id }}">
                        <button class="btn btn-primary">Submit</button>
                    </div>


                </div>




            </form>
        </div>
    </div>
</div>
@endsection

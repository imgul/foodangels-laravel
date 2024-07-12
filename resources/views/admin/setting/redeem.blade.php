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
                        <label for="">Score Value</label>
                        <input type="text" class="form-control" name="score_value" value="{{ $redeem_setting->score_value }}">
                        @error('score_value')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Reward Value</label>
                        <input type="text" class="form-control" name="reward_value" value="{{ $redeem_setting->reward_value }}">
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
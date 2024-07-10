@extends('admin.layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.min.css" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('main-content')

<section class="section">
	<div class="section-header">
		<h1>{{ __('levels.promo') }}</h1>
		{{ Breadcrumbs::render('promo/add') }}
	</div>

	<div class="section-body">
		<div class="row">
			<div class="col-12 col-md-12 col-lg-12">
				<div class="card">
					<form action="{{ route('admin.promo.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
						@csrf
						<div class="card-body">
							<div class="form-row">
								@if(auth()->user()->myrole == 1)
								<div class="form-group col">
									<label for="area">{{ __('levels.branch') }}</label>
									<select name="restaurant_id" id="restaurant_id" class="select2 form-control @error('restaurant_id') is-invalid red-border @enderror">
										<option value="0">{{ __('levels.select_restaurant') }}</option>
										@if(!blank($restaurants))
										@foreach($restaurants as $restaurant)
										<option value="{{ $restaurant->id }}" {{ (old('restaurant_id') == $restaurant->id) ? 'selected' : '' }}>{{ $restaurant->name }}
										</option>
										@endforeach
										@endif
									</select>
									@error('restaurant_id')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>

								@else
								<input id="restaurant_id" type="hidden" name="restaurant_id" value="{{auth()->user()->restaurant_id }}">
								@endif
								<div class="form-group col">
									<label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
									<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
									@error('name')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>
							<div class="form-row">

								<div class="form-group col">
									<label>{{ __('levels.amount') }}</label> <span class="text-danger">*</span>
									<div class="input-group">
										<input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" aria-describedby="basic-addon2">
										<div class="input-group-append">
										  <span class="input-group-text bg-secondary" id="basic-addon2"><i class="fas fa-percentage"></i></span>
										</div>
									</div>
									@error('amount')
									<div class="text-danger">
										{{ $message }}
									</div>
									@enderror
								</div>
									<div class="form-group col">
									<label>{{ __('levels.user_limit') }}</label> <span class="text-danger">*</span>
									<div class="input-group">
										<input type="number" class="form-control @error('user_limit') is-invalid @enderror" name="user_limit" value="{{ old('user_limit') }}" aria-describedby="basic-addon2">
										<div class="input-group-append">
										  <span class="input-group-text bg-secondary" id="basic-addon2"><i class="fas fa-percentage"></i></span>
										</div>
									</div>
									@error('user_limit')
									<div class="text-danger">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="form-group col">
									<label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
									<select name="status" class="form-control @error('status') is-invalid @enderror">
										@foreach(trans('statuses') as $key => $status)
										<option value="{{ $key }}" {{ (old('status') == $key) ? 'selected' : '' }}>{{ $status }}</option>
										@endforeach
									</select>
									@error('status')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>

							</div>

							<div class="form-row">
								<div class="form-group col">
									<label>{{ __('levels.starts_at') }}</label> <span class="text-danger">*</span>
									<input type="text" name="from_date" class="datepicker form-control @error('from_date') is-invalid @enderror" value="{{ old('from_date') }}">
									@error('from_date')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="form-group col">
									<label>{{ __('levels.ends_at') }}</label> <span class="text-danger">*</span>
									<input type="text" name="to_date" class="datepicker form-control @error('to_date') is-invalid @enderror" value="{{ old('to_date') }}">
									@error('to_date')
									<div class="invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>

						</div>

						<div class="card-footer">
							<button class="btn btn-primary mr-1" type="submit">{{ __('levels.submit') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.full.min.js" integrity="sha512-hDFt+089A+EmzZS6n/urree+gmentY36d9flHQ5ChfiRjEJJKFSsl1HqyEOS5qz7jjbMZ0JU4u/x1qe211534g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/promo/create.js') }}"></script>
@endsection

@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('setting.rewards') }}</h1>
        {{ Breadcrumbs::render('rewards_create') }}
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">




                    <div class="card-body">

                        <form action="{{ route('admin.rewards.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Select User</label>
                                    <select name="loyalty_customer_id" id="" class="form-control" required>
                                        <option value="">--Select--</option>
                                        @foreach($loyalty_users as $key)
                                        <option value="{{ $key->customer_id }},{{ $key->id }}">{{ $key->user->first_name . ' ' .  $key->user->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('loyalty_customer_id')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <select class="form-control form-control-sm" id="variation_category_id" onchange="categoryProduct()">
                                                <option value="">Select Category</option>
                                                @foreach($categoryObj as $category)
                                                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-5">
                                            <select class="form-control form-control-sm" id="variation_menuItem_id">
                                                @if(!blank($menuItemObj))
                                                <option value="">Select Menu item</option>
                                                @foreach($menuItemObj as $menuObj)
                                                <option value="{{ $menuObj->id }}"> {{ $menuObj->name }} ( {{ $menuObj->unit_price }} )</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <button class="btn btn-primary btn-sm" type="button" onclick="return variationMenuItemAdd()"> <i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>

                                    <div id="reward-menus" class="mt-3">

                                    </div>



                                </div>
                            </div>

                            <div id="hidden-menu" class="d-none">

                            </div>

                            <div class="mt-2">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    var categoryProductUrl = '{{ route("admin.category.menuItem") }}';

    function categoryProduct() {
        var categoryID = $("select#variation_category_id" + " option").filter(":selected").val();
        $.ajax({
            type: 'POST',
            url: categoryProductUrl,
            data: {
                'category_id': categoryID
            },
            dataType: "html",
            success: function(data) {
                $('#variation_menuItem_id').html(data);
            }
        });
    }

    function variationMenuItemAdd() {

        var menu_id = $('#variation_menuItem_id option:selected').val();
        var menu_name = $('#variation_menuItem_id option:selected').text();



        $('#reward-menus').append('<div class="d-flex justify-content-around">  <div class="rounded p-1 bg-light w-50 mb-2 me-2"> ' + menu_name + ' </div> <div class="">  <button class="btn btn-danger btn-sm removeBtn me-auto" onclick="removeDiv(this, ' + menu_id + ')"><i class="fa fa-trash"></i></button> </div>  </div>');

        $('#hidden-menu').append('<input type="hidden" name="menu[]" value="' + menu_id + '">')

    }

    function removeDiv(button, menu_id) {
        $(button).parent().parent().remove();

        $('#hidden-menu').find('input[value="' + menu_id + '"]').remove();
    }
</script>

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
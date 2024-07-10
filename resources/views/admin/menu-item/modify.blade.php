@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('main-content')
<section class="section">
    <div class="section-header">
        <h1>{{ __('restaurant.menu_item') }}</h1>
        {{ Breadcrumbs::render('menu-items/edit', $menuItem) }}
    </div>
    <div class="section-body">
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body" id="variationTypeBody">
                                        <h3 class="mb-3">{{ __('restaurant.product_variation') }}</h3>

                                        <div class="row mb-4">
                                            <div class="col-md-5">
                                                <label>{{ __('levels.type') }}</label> <span class="text-danger">*</span>
                                                <select name="variation_type_id" id="variation_type_id" class="form-control @error('variation_type_id') is-invalid @enderror">
                                                    @if(!blank($menuItemTypes))
                                                        @foreach($menuItemTypes as $key => $menuItemType)
                                                            <option value="{{ $menuItemType->id }}" @if(!blank($vTypeID) && $vTypeID->id ==$menuItemType->id){{'selected' }} @endif>{{ $menuItemType->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('variation_type_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox checkbox-xl variationAdd">
                                                    <input type="checkbox" name="variant" class="custom-control-input" id="checkbox-variant" {{ (old('variant') == 'on') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="checkbox-variant">{{__('restaurant.is_item')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary variationAdd" id="variation-type-add" type="button"> <i class="fa fa-plus"></i> {{ __('restaurant.add_menu_item_variation') }}</button>
                                            </div>

                                        </div>
                                        @if(!blank(App\Models\MenuItemType::where('status', App\Enums\Status::ACTIVE)->orderBy('id','desc')->get()) && !blank($menu_item_variations))
                                            @foreach($menu_item_variations as $key => $menu_item_variation)
                                                @foreach(App\Models\MenuItemType::where('status', App\Enums\Status::ACTIVE)->orderBy('id','desc')->get() as $type)
                                                    @if( isset($menu_item_variation[$type->id])    && !blank($menu_item_variation[$type->id]))
                                                        @if($key == 0)
                                                            <div class="variationOptionsCss mb-3" id="variationType{{ $type->id }}">
                                                                <h5 class="mb-3">{{ $type->name }}</h5>
                                                                <div class="table-responsive variationTypeTable">
                                                                    <input type="hidden" id="variationIsItem{{ $type->id }}" value="{{ $key }}">
                                                                    <input type="hidden" id="variationTypeTable{{ $type->id }}" value="{{ $type->id }}">
                                                                    <table class="table table-striped variationTypeTable{{ $type->id }}">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{ __('levels.name') }}</th>
                                                                            <th>{{ __('levels.price') }}</th>
                                                                            <th>{{ __('levels.product_info') }}</th>
                                                                            <th>{{ __('levels.actions') }}
                                                                                <button class="btn btn-danger btn-sm float-right" onclick="removeVariationTypeBtn(event,'{{ $type->id  }}')"><i class="fa fa-times-circle"></i></button>

                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" id="variationName{{ $type->id }}" placeholder="Name" name="name" class="form-control form-control-sm">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" step="0.01" id="variationPrice{{ $type->id }}" placeholder="Price" class="form-control form-control-sm" value="">
                                                                            </td>
                                                                            <td>
                                                                                <textarea id="variationProductInfo{{ $type->id }}" placeholder="Product info" class="form-control form-control-sm summernote-simple variation-height-textarea "></textarea>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-primary btn-sm" onclick="return variationAdd(event,'{{ $type->id }}')"> <i class="fa fa-plus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        @foreach($menu_item_variation[$type->id] as $indexID => $menu_itemVariation)

                                                                            <tr class="mt-2" id="variation{{ $type->id }}">
                                                                                <td>
                                                                                    <input type="text" name="variation[{{ $type->id }}][{{$indexID}}][1][name]" placeholder="Name" value="{{$menu_itemVariation->name}}" class="form-control form-control-sm"></td>
                                                                                <td>
                                                                                    <input type="number" name="variation[{{ $type->id }}][{{$indexID}}][1][price]" placeholder="Price" value="{{ $menu_itemVariation->unit_price }}" class="form-control form-control-sm">
                                                                                </td>
                                                                                <td>
                                                                                    <textarea name="variation[{{ $type->id }}][{{$indexID}}][1][product_info]" placeholder="Product info" class="form-control form-control-sm summernote-simple variation-height-textarea mt-2">{{$menu_itemVariation->product_info}}</textarea>
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-danger btn-sm removeBtn"><i class="fa fa-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="variationOptionsCss mb-3" id="variationType{{ $type->id }}">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-6">
                                                                        <h5 class="">{{ $type->name }}</h5>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="custom-control custom-checkbox checkbox-xl float-right">
                                                                            <input type="checkbox" class="custom-control-input" id="checkbox-{{ $type->id }}" checked="">
                                                                            <label class="custom-control-label">is Item</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive variationTypeTable">
                                                                    <input type="hidden" id="variationIsItem{{ $type->id }}" value="{{ $key }}">
                                                                    <input type="hidden" id="variationTypeTable{{ $type->id }}" value="{{ $type->id }}">
                                                                    <table class="table table-striped variationTypeProductTable{{ $type->id }}">
                                                                        <thead>
                                                                        <tr>
                                                                            <th  class="col-5">{{ __('levels.category') }}</th>
                                                                            <th class="col-5">{{ __('levels.menu_item') }}</th>
                                                                            <th>{{ __('levels.actions') }}
                                                                                <button class="btn btn-danger btn-sm float-right" onclick="removeVariationTypeBtn(event,'{{ $type->id  }}')"><i class="fa fa-times-circle"></i></button>
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="col-5">
                                                                                <select class="form-control form-control-sm" id="variation_category_id{{ $type->id }}" onchange="categoryProduct('{{ $type->id }}')">
                                                                                    <option value="">Select Category</option>
                                                                                    @foreach($categoryObj as $category)
                                                                                        <option  value="{{ $category->id }}" > {{ $category->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td class="col-5">
                                                                                <select class="form-control form-control-sm" id="variation_menuItem_id{{ $type->id }}">
                                                                                    @if(!blank($menuItemObj))
                                                                                        <option value="">Select Menu item</option>
                                                                                        @foreach($menuItemObj as $menuObj)
                                                                                            <option  value="{{ $menuObj->id }}" > {{ $menuObj->name }} ( {{ $menuObj->unit_price }} )</option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-primary btn-sm" onclick="return variationMenuItemAdd(event,'{{ $type->id }}')"> <i class="fa fa-plus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        @foreach($menu_item_variation[$type->id] as $menuitemVariation)

                                                                            <tr class="mt-2">
                                                                                <td colspan="2">
                                                                                    <input type="hidden" value="{{ $menuitemVariation->related_menu_item_id }}">
                                                                                    <input type="text" readonly="" name="variation[{{ $type->id }}][name]" placeholder="Name" value="{{ $menuitemVariation->relatedMenuItem->name }} {{ $menuitemVariation->relatedMenuItem->unit_price }}" class="form-control form-control-sm">
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-danger btn-sm removeBtn">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                        @endif
                                                    @endif
                                                @endforeach

                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 mt-3">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body" id="optionsTypeBody">
                                        <h3 class="mb-3">{{ __('restaurant.product_options') }}</h3>
                                        <div class="row mb-4">
                                            <div class="col-md-5">
                                                <label>{{ __('levels.type') }}</label> <span class="text-danger">*</span>
                                                <select name="options_type_id" id="options_type_id" class="form-control @error('options_type_id') is-invalid @enderror">
                                                    @if(!blank($menuItemTypes))
                                                        @foreach($menuItemTypes as $key => $menuItemTypeOption)
                                                            <option value="{{ $menuItemTypeOption->id }}" @if(!blank($oTypeID) && $oTypeID->id ==$menuItemTypeOption->id){{'selected' }} @endif>{{ $menuItemTypeOption->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('options_type_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <div class="custom-control custom-checkbox checkbox-xl variationAdd">
                                                    <input type="checkbox" name="variant" class="custom-control-input" id="checkbox-options" {{ (old('variant') == 'on') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="checkbox-options">{{__('restaurant.is_item')}}</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary variationAdd" id="options-type-add" type="button" > <i class="fa fa-plus"></i> {{ __('restaurant.add_menu_item_options') }}</button>
                                            </div>

                                        </div>
                                        @if(!blank($menuItemTypes) && !blank($menu_item_options))

                                            @foreach($menu_item_options as $optionsType => $menu_item_options)

                                                @foreach($menuItemTypes as $menuOptionType)
                                                    @if(isset($menu_item_options[$menuOptionType->id]) && !blank($menu_item_options[$menuOptionType->id]))
                                                        @if($optionsType == 0)
                                                            <div class="variationOptionsCss mb-3" id="optionsType{{ $menuOptionType->id }}">
                                                                <h5 class="mb-3">{{ $menuOptionType->name }}</h5>
                                                                <div class="table-responsive optionsTypeTable">
                                                                    <input type="hidden" id="optionsIsItem{{ $menuOptionType->id }}" value="{{ $optionsType }}">
                                                                    <input type="hidden" id="optionsTypeTable{{ $menuOptionType->id }}" value="{{ $menuOptionType->id }}">
                                                                    <table class="table table-striped optionsTypeTable{{ $menuOptionType->id }}">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>{{ __('levels.name') }}</th>
                                                                            <th>{{ __('levels.price') }}</th>
                                                                            <th>{{ __('levels.product_info') }}</th>
                                                                            <th>{{ __('levels.actions') }}
                                                                                <button class="btn btn-danger btn-sm float-right" onclick="removeTypeBtn(event,'{{ $menuOptionType->id  }}')"><i class="fa fa-times-circle"></i></button>
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="text" id="optionsName{{ $menuOptionType->id }}" placeholder="Name" name="name" class="form-control form-control-sm">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" step="0.01" id="optionsPrice{{ $menuOptionType->id }}" placeholder="Price" class="form-control form-control-sm" value="">
                                                                            </td>
                                                                            <td>
                                                                                <textarea id="optionsProductInfo{{ $menuOptionType->id }}" placeholder="Product info" class="form-control form-control-sm summernote-simple options-height-textarea "></textarea>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-primary btn-sm" onclick="return optionsAdd(event,'{{ $menuOptionType->id }}')"> <i class="fa fa-plus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        @foreach($menu_item_options[$menuOptionType->id] as $OptionsIndexID => $menu_itemVariation)

                                                                            <tr class="mt-2" id="options{{ $menuOptionType->id }}">
                                                                                <td>
                                                                                    <input type="text" name="options[{{ $menuOptionType->id }}][{{$OptionsIndexID}}][1][name]" placeholder="Name" value="{{$menu_itemVariation->name}}" class="form-control form-control-sm"></td>
                                                                                <td>
                                                                                    <input type="number" name="options[{{ $menuOptionType->id }}][{{$OptionsIndexID}}][1][price]" placeholder="Price" value="{{ $menu_itemVariation->unit_price }}" class="form-control form-control-sm">
                                                                                </td>
                                                                                <td>
                                                                                    <textarea name="options[{{ $menuOptionType->id }}][{{$OptionsIndexID}}][1][product_info]" placeholder="Product info" class="form-control form-control-sm summernote-simple options-height-textarea mt-2">{{$menu_itemVariation->product_info}}</textarea>
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-danger btn-sm removeBtn"><i class="fa fa-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="variationOptionsCss mb-3" id="optionsType{{ $menuOptionType->id }}">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-6">
                                                                        <h5 class="">{{ $menuOptionType->name }}</h5>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="custom-control custom-checkbox checkbox-xl float-right">
                                                                            <input type="checkbox" class="custom-control-input" id="checkbox-{{ $menuOptionType->id }}" checked="">
                                                                            <label class="custom-control-label">is Item</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive optionsTypeTable">
                                                                    <input type="hidden" id="optionsIsItem{{ $menuOptionType->id }}" value="{{ $optionsType }}">
                                                                    <input type="hidden" id="optionsTypeTable{{ $menuOptionType->id }}" value="{{ $menuOptionType->id }}">
                                                                    <table class="table table-striped optionsTypeProductTable{{ $menuOptionType->id }}">
                                                                        <thead>
                                                                        <tr>
                                                                            <th  class="col-5">{{ __('levels.category') }}</th>
                                                                            <th class="col-5">{{ __('levels.menu_item') }}</th>
                                                                            <th>{{ __('levels.actions') }}
                                                                                <button class="btn btn-danger btn-sm float-right" onclick="removeTypeBtn(event,'{{ $menuOptionType->id  }}')"><i class="fa fa-times-circle"></i></button>
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="col-5">
                                                                                <select class="form-control form-control-sm" id="options_category_id{{ $menuOptionType->id }}" onchange="categoryProduct('{{ $menuOptionType->id }}')">
                                                                                    <option value="">Select Category</option>
                                                                                    @foreach($categoryObj as $category)
                                                                                        <option  value="{{ $category->id }}" > {{ $category->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                            <td class="col-5">
                                                                                <select class="form-control form-control-sm" id="options_menuItem_id{{ $menuOptionType->id }}">
                                                                                    @if(!blank($menuItemObj))
                                                                                        <option value="">Select Menu item</option>
                                                                                        @foreach($menuItemObj as $menuobg)
                                                                                            <option  value="{{ $menuobg->id }}" > {{ $menuobg->name }} ( {{ $menuobg->unit_price }} )</option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-primary btn-sm" onclick="return optionsMenuItemAdd(event,'{{ $menuOptionType->id }}')"> <i class="fa fa-plus"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        @foreach($menu_item_options[$menuOptionType->id] as $menuitemOptions)

                                                                            <tr class="mt-2">
                                                                                <td colspan="2">
                                                                                    <input type="hidden" value="{{ $menuitemOptions->related_menu_item_id }}">
                                                                                    <input type="text" readonly="" name="options[{{ $menuOptionType->id }}][name]" placeholder="Name" value="{{ $menuitemOptions->relatedMenuItem->name }} {{ $menuitemOptions->relatedMenuItem->unit_price }}" class="form-control form-control-sm">
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-danger btn-sm removeBtn">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach

                                            @endforeach
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <button class="btn btn-primary" id="addVariationOptions" type="button"> {{ __('levels.submit') }}</button>
                                <div id="variationError" style="color:red; margin-top: 5px;"></div><div id="optionError" style="color:red;"></div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
{{--    <script>--}}
{{--        @php--}}
{{--            $menu_item_variation_count = 0;--}}
{{--            if(!blank(session('variation'))) {--}}
{{--                $menu_item_variation_count = count(session('variation'));--}}
{{--            } else {--}}
{{--                $menu_item_variation_count = $menu_item_variations->count();--}}
{{--            }--}}

{{--            $menu_item_option_count = 0;--}}
{{--            if(!blank(session('option'))) {--}}
{{--                $menu_item_option_count = count(session('option'));--}}
{{--            } else {--}}
{{--                $menu_item_option_count = $menu_item_options->count();--}}
{{--            }--}}
{{--        @endphp--}}

{{--        var menu_item_variation_count  = <?=$menu_item_variation_count?>;--}}
{{--        var menu_item_option_count     = <?=$menu_item_option_count?>;--}}
{{--    </script>--}}

    <script>
        @php
            $menu_item_variation_count = 0;
            if(!blank(session('variation'))) {
                $menu_item_variation_count = count(session('variation'));
            } else {
                $menu_item_variation_count = $menu_item_variations->count();
            }

            $menu_item_option_count = 0;
            if(!blank(session('option'))) {
                $menu_item_option_count = count(session('option'));
            } else {
                $menu_item_option_count = $menu_item_options->count();
            }
        @endphp

        var menuItemID                  = '{{ $menuItem->id }}';
        var menuItemVariationCount      = '{{ $menu_item_variations->count() }}';
        var menuItemOptionsCount        = '{{ $menu_item_options->count() }}';
        var menuItemsUrl                = '{{ route('admin.menu-items.index') }}';
        var categoryProductUrl          = '{{ route('admin.category.menuItem') }}';
        var variationOptionsAddUrl      = '{{ route('admin.menu-items.modify', $menuItem) }}';
        var LabelCategory               = '{{ __('levels.category') }}';
        var LabelMenuItem               = '{{ __('levels.menu_item') }}';
        var LabelName                   = '{{ __('levels.name') }}';
        var LabelPrice                  = '{{ __('levels.price') }}';
        var LabelActions                = '{{ __('levels.actions') }}';
        var LabelProductInfo            = '{{ __('levels.product_info') }}';
        var menuItemObj                 = @json($menuItemObj);
        var categoryObj                 = @json($categoryObj);
        var menu_item_variation_count   = <?=$menu_item_variation_count?>;
        var menu_item_options_count     = <?=$menu_item_option_count?>;
        console.log(menuItemVariationCount);
        console.log(menuItemOptionsCount);
    </script>
    <script src="{{ asset('js/menu-item/modify.js') }}"></script>
@endsection

<div>
    <!--======= PRODUCT MODAL PART START ========-->
    <div wire:ignore.self class="modal fade product-modal" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @if (!blank($menuItem))
                    <div class="product-modal-media">
                        <img loading="lazy" src="{{ $menuItem->image }}" alt="modal">
                        <button class="fa-regular fa-circle-xmark" type="button" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="product-modal-group">
                        <h3 class="product-modal-title">{{ $menuItem->name }} </h3>
                        <p class="product-modal-describe">{!! $menuItem->description !!} </p>
                    </div>

                    <div class="product-modal-group">
                        <dl class="product-modal-subset mb-0">
                            <dt>{{ __('frontend.price') }} </dt>
                            <span class="fw-bold"> {{ setting('currency_code') }}
{{--                                @if($price)--}}
{{--                                    Price is: {{ $price }}--}}
{{--                                @endif--}}
                                @if($cartPrice)
                                    {{ $cartPrice }}
                                @endif
{{--                                @if(!$price && !$cartPrice)--}}
{{--                                    {{ $menuItem->unit_price - $menuItem->discount_price }}--}}
{{--                                @endif--}}
{{--                                @if($price)--}}
{{--                                    {{ $price }}--}}
{{--                                @elseif($cartPrice)--}}
{{--                                    {{ $cartPrice }}--}}
{{--                                @else--}}
{{--                                    {{ $menuItem->unit_price - $menuItem->discount_price }}--}}
{{--                                @endif--}}

                                    </span>
                        </dl>
                    </div>

                    <form wire:submit.prevent="submit({{ $restaurant->id }},{{ $menuItem->id }})">

                        @if (!blank($menuItem->variations))
                            <div class="product-modal-group">
                                <dl class="product-modal-subset">
                                    <dt>{{ __('frontend.combo') }} </dt>
                                    <dd class="require"> {{ __('frontend.required') }} </dd>
                                </dl>
                                <ul class="product-modal-list">
                                    @if(!blank($menuItemTypes))
                                        @foreach(App\Models\MenuItemType::where('status', App\Enums\Status::ACTIVE)->orderBy('id','desc')->get() as $type)
                                            @if(isset($menuItemVariations[$type->id]))

                                                <div class="payment-tab-trigger">
                                                    <h5 class="variation-title">{{ $type->name}}</h5>
                                                    <select name="ext" class="form-control variation-select-height" wire:change="changeVariation($event.target.value, {{$type->id}})" onchange="showVariationInfo('{{ $type->id }}')" id="showVariationInfo{{ $type->id }}">
                                                        <!--@if($type->id != 13 || $type->id != 2)-->
                                                        <!-- <option value="" data-productInfo=""> -->
                                                        <!--     Select-->
                                                        <!-- </option>-->
                                                        <!-- @endif -->
                                                        @foreach($menuItemVariations[$type->id] as $key => $variation)

                                                            @if($variation['type'] == 0)

                                                                <option value="{{ $variation['id'] }}" data-productInfo="{{ $variation['product_info'] }}"  <?php if(isset($variationsType[$type->id]) && $variationsType[$type->id] ==  $variation['id'] )  echo 'selected';  ?>   >
                                                                    {{ $variation['name'] }}
                                                                    @if($variation['unit_price'])( + {{ currencyName($variation['unit_price']) }})@endif
                                                                </option>
                                                            @else
                                                                <option value="{{ $variation['id'] }}" data-productInfo="{{$variation['relatedmenuitem']['product_info'] }}"  <?php if(isset($variationsType[$type->id]) && $variationsType[$type->id] == $variation['id'] )  echo 'selected';?>  >
                                                                    {{ $variation['relatedmenuitem']['name'] }} ( + {{ currencyName($variation['relatedmenuitem']['unit_price']) }} )
                                                                </option>
                                                            @endif


                                                        @endforeach
                                                    </select>

                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(!blank($menuItemTypes))
                                        @foreach($menuItemTypes as $menuItemType)
                                            @if(isset($menuItemOptions[$menuItemType->id]))
                                                <h5 class="variation-title">{{ $menuItemType->name}}
                                                    <div class="checkboxes in-row margin-bottom-20">
                                                        @php
                                                            $i = 0;
                                                            $count = count($menuItemOptions[$menuItemType->id]);

                                                        @endphp
                                                        @foreach($menuItemOptions[$menuItemType->id] as $option)
                                                            @php
                                                                $i++;
                                                            @endphp
                                                            @if($option['type'] == 0)
                                                                @if($i <= 2)
                                                               
                                                                <div class="mb-1">
        
                                                                    <input wire:change="changeOption($option['id'])" wire:model="options" id="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}" type="checkbox" value="{{ $option['id'] }}" name="options[]">
                                                                    <label class="optional-checkbox fs-6 fw-normal" for="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}">{{$option['name']}}
                                                                    <span class="optional-price"> @if($option['unit_price'])+
                                                                            {{currencyName($option['unit_price'])}}@endif</span>
                                                                            
                                                                 </div>
                                                                    @if($option['product_info'])
                                                                     

                                                                    @endif
                                                                    <div class="collapse" id="info{{ $option['id'] }}">
                                                                        <div class="card card-body">
                                                                            {{ $option['product_info']}}
                                                                        </div>
                                                                    </div>
                                                                </label>

                                                                @if($option['product_info'])
                                                                    <a onclick="showProductInfo('{{ $option['product_info'] }}')" productdetail=" {{ $option['product_info']}}"><i class="fa fa-info-circle menu-readmore-btn" aria-hidden="true" style="padding-left: ;position: relative;right: 14px;"></i></a>
                                                                @endif



                                                                @else
                                                                    <div wire:ignore.self class="textarea" style="display: none">
                                                                        <input wire:change="changeOption($option['id'])" wire:model="options" class="form-checkbox" id="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}" type="checkbox" value="{{ $option['id'] }}" name="options[]">
                                                                        <label class=" optional-checkbox" for="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}">{{$option['name']}}
                                                                            <span class="optional-price"> @if($option['unit_price'])+
                                                                                {{currencyName($option['unit_price'])}}@endif</span>
                                                                            @if($option['product_info'])
                                                                                <a class="ml-4 text-primary option-info" data-toggle="collapse" href="javascript:void(0)" onclick="showInfo('info{{ $option['id'] }}')" role="button" aria-expanded="false">{{ __('frontend.product_info') }}
                                                                                </a>
                                                                            @endif
                                                                            <div class="collapse" id="info{{ $option['id'] }}">
                                                                                <div class="card card-body">
                                                                                    {{ $option['product_info']}}
                                                                                </div>
                                                                            </div>
                                                                        </label>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                @if($i <= 2) <input wire:model="options" class="form-checkbox" id="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}" type="checkbox" value="{{ $option['id'] }}" name="options[]">
                                                                <label class="optional-checkbox" for="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}">{{$option->relatedmenuitem['name']}}
                                                                    <span class="optional-price"> +
                                                    {{currencyName($option->relatedmenuitem['unit_price'])}}</span>
                                                                    @if($option->relatedmenuitem['product_info'])<a class="ml-4 text-primary option-info" href="javascript:void(0)" onclick="showInfo('info{{ $option['id'] }}')" class="product_info">{{ __('frontend.product_info') }}</a>@endif
                                                                </label>

                                                                <div class="collapse" id="info{{ $option['id'] }}">
                                                                    <div class="card card-body">
                                                                        {{ $option->relatedmenuitem['product_info']}}
                                                                    </div>
                                                                </div>
                                                                @else
                                                                    <div wire:ignore.self class="textarea" style="display: none">
                                                                        <input wire:model="options" class="form-checkbox" id="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}" type="checkbox" value="{{ $option['id'] }}" name="options[]">
                                                                        <label class="optional-checkbox" for="check-option-{{ __('other') }}-{{ $option['id'] }}-{{ $option['id'] }}">{{$option->relatedmenuitem['name']}}
                                                                            <span class="optional-price"> +
                                                        {{currencyName($option->relatedmenuitem['unit_price'])}}</span>
                                                                            @if($option->relatedmenuitem['product_info'])<a class="ml-4 text-primary option-info" href="javascript:void(0)" onclick="showInfo('info{{ $option['id'] }}')" class="product_info">{{ __('frontend.product_info') }}</a>@endif
                                                                        </label>

                                                                        <div class="collapse" id="info{{ $option['id'] }}">
                                                                            <div class="card card-body">
                                                                                {{ $option->relatedmenuitem['product_info']}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        @if($count > 2)
                                                            <div class="mt-1">
                                                                <a href="javascript:void(0)" wire:ignore id="seeMore" onclick="showOption()" class="mt-5" style="cursor: pointer"><i class="fas fa-angle-up see-icon"></i><u class="see-text">{{ __('frontend.show_more') }}</u></a>
                                                            </div>
                                                        @endif
                                                    </div>

                                            @endif
                                        @endforeach
                                    @endif

{{--                                    @if (!blank($menuItem->variations))--}}
{{--                                        @foreach ($menuItem->variations as $index => $variation)--}}
{{--                                            <li>--}}
{{--                                                <input--}}
{{--                                                    wire:model.live="variationID{{ isset($menuItem->variations->menu_item_id) ? $menuItem->variations->menu_item_id : '' }}"--}}
{{--                                                    id="{{ $variation->name }}" name="variationID" type="radio"--}}
{{--                                                    value="{{ $variation->id }}" class="form-radio"--}}
{{--                                                    @if ($index === 0) checked @endif>--}}
{{--                                                <label for="{{ $variation->name }}"> {{ $variation->name }}</label>--}}
{{--                                                <span> {{ setting('currency_code') }}--}}
{{--                                                    {{ $variation->price - $variation->discount_price }} </span>--}}
{{--                                            </li>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
                                </ul>
                            </div>
                        @endif

{{--                        @if (!blank($menuItem->options))--}}
{{--                            <div class="product-modal-group">--}}
{{--                                <dl class="product-modal-subset">--}}
{{--                                    <dt>{{ __('frontend.addon') }}</dt>--}}
{{--                                    <dd class="option">{{ __('frontend.optional') }}</dd>--}}
{{--                                </dl>--}}
{{--                                <ul class="product-modal-list">--}}
{{--                                    @foreach ($menuItem->options as $option)--}}
{{--                                        <li>--}}
{{--                                            <input wire:model.live="options"--}}
{{--                                                id="check-option-{{ __('other') }}-{{ $menuItem->id }}-{{ $option->id }}"--}}
{{--                                                type="checkbox" value="{{ $option->id }}" name="options[]"--}}
{{--                                                class="form-checkbox">--}}
{{--                                            <label--}}
{{--                                                for="check-option-{{ __('other') }}-{{ $menuItem->id }}-{{ $option->id }}">{{ $option->name }}--}}
{{--                                            </label>--}}
{{--                                            <span> + {{ setting('currency_code') }}--}}
{{--                                                {{ $option->price }}</span>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        <div class="product-modal-group">
                            <dl class="product-modal-subset">
                                <dt>{{ __('frontend.special_instructions') }} </dt>
                                <dd class="option">{{ __('frontend.optional') }}</dd>
                            </dl>
                            <input class="product-modal-instruct WYSIWYG" name="instructions" cols="40"
                                rows="3" id="instructions" wire:model.live="instructions" spellcheck="true"
                                placeholder="Ex: Special Instructions">
                        </div>

                        <div class="product-modal-footer">
                            <div class="cart-counter">
                                <button type="button" wire:click.prevent="removeItemQty()"
                                    class="fa-solid fa-minus cart-counter-minus" id="qut-button-minus"></button>
                                <input type="number" step=".01" name="product_quantity" id="quantity"
                                    wire:model.live="quantity" value="{{ $quantity }}" min="1"
                                    max="99" class="cart-counter-value pppQty">
                                <button type="button" wire:click.prevent="addItemQty()" id="qut-button-plus"
                                    class="fa-solid fa-plus cart-counter-plus"></button>
                            </div>

                            <button class="cart-btn" data-bs-dismiss="modal">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.6333 7.4665C16.075 6.84984 15.2333 6.4915 14.0666 6.3665V5.73317C14.0666 4.5915 13.5833 3.4915 12.7333 2.72484C11.875 1.9415 10.7583 1.57484 9.59995 1.68317C7.60828 1.87484 5.93328 3.79984 5.93328 5.88317V6.3665C4.76662 6.4915 3.92495 6.84984 3.36662 7.4665C2.55828 8.3665 2.58328 9.5665 2.67495 10.3998L3.25828 15.0415C3.43328 16.6665 4.09162 18.3332 7.67495 18.3332H12.325C15.9083 18.3332 16.5666 16.6665 16.7416 15.0498L17.325 10.3915C17.4166 9.5665 17.4333 8.3665 16.6333 7.4665ZM9.71662 2.8415C10.55 2.7665 11.3416 3.02484 11.9583 3.58317C12.5666 4.13317 12.9083 4.9165 12.9083 5.73317V6.3165H7.09162V5.88317C7.09162 4.39984 8.31662 2.97484 9.71662 2.8415ZM7.01662 10.9582H7.00828C6.54995 10.9582 6.17495 10.5832 6.17495 10.1248C6.17495 9.6665 6.54995 9.2915 7.00828 9.2915C7.47495 9.2915 7.84995 9.6665 7.84995 10.1248C7.84995 10.5832 7.47495 10.9582 7.01662 10.9582ZM12.85 10.9582H12.8416C12.3833 10.9582 12.0083 10.5832 12.0083 10.1248C12.0083 9.6665 12.3833 9.2915 12.8416 9.2915C13.3083 9.2915 13.6833 9.6665 13.6833 10.1248C13.6833 10.5832 13.3083 10.9582 12.85 10.9582Z"
                                        fill="white" />
                                </svg>
                                <span>{{ __('frontend.add_to_cart') }} </span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <!--======= PRODUCT MODAL PART END =====-->
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).on('click', '.menu-readmore-btn', function(event) {
        event.preventDefault();
        $('.custom-border').css('display', 'none')
    });

    $(document).on('click', '.swal-button--confirm', function(event) {
        event.preventDefault();
        $('.custom-border').css('display', 'block')
    });

    function showProductInfo(id) {
        // var productdetail = $(e).attr('productdetail');
        swal({
            title: "Description",
            text: id,
            html: true
        });
    }

    function showInfo(id) {
        $('#' + id).toggle('slow');
    }

    function showOption() {
        var x = document.getElementsByClassName("textarea");
        Array.from(x).forEach((x) => {
            if (x.style.display === "none") {
                x.style.display = "block";
                document.getElementById("seeMore").innerHTML = '<i class="fas fa-angle-up see-icon"></i> <u class="see-text">' + '{{ __("frontend.show_less")}}' + '</u>';
            } else {
                x.style.display = "none";
                document.getElementById("seeMore").innerHTML = '  <i class="fas fa-angle-up see-icon"></i> <u class="see-text">' + '{{ __('frontend.show_more ') }}' + '</u>';
            }
        })
    }

    function showVariationInfo(id) {
        var name = $("select#showVariationInfo" + id + " option").filter(":selected").text();
        var productInfo = $("select#showVariationInfo" + id + " option").filter(":selected").attr('data-productInfo');
        if (productInfo) {
            $('#variationInfo' + id).show();
            $('#variationItemsInfo' + id).text(name);
            $('#VariationProductInfo' + id).text(productInfo);
        } else {
            $('#variationInfo' + id).hide();
        }

    }

    function testrishi() {
        console.log("yes working");
        /*           const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById("demo").innerHTML =
            this.responseText;
          }
          xhttp.open("GET", "https://laravel.food-angels.com/Livewire/ShowCart/changeVariation/267/5");
          xhttp.send();
                 */

        const $select = document.querySelector('#showVariationInfo9');
        $select.value = '523';


        console.log("do");
    }
</script>
<script>
    document.addEventListener('livewire:load', function() {

        var select = document.querySelector('#showVariationInfo9');
        console.log(select);
    })
</script>

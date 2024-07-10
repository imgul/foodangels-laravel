<div>
    <div id="listing-product-list">
        @if(!blank($promottedMenus))
        <div id="listing-product-list-category-{{ __('other') }}" class="listing-nav-container-body">
            <div class="container-fluid custom-container">
                <div class="col-lg-12 col-md-12">
                    <div class="#">
                        <div class="row">
                            @foreach($promottedMenus as $promottedMenu)
                            <div class="col-md-6 padding-left-0">
                                <div class="style-2">
                                    <div class="tabs-container border-radius">
                                        <div class="tab-content food-price-tab" id="tab1a">
                                            <div class="product-description-section">
                                                <a href="#variation-{{$promottedMenu->id}}" wire:click.prevent="addToCartPromoModal({{$promottedMenu->id}},{{ promoPrice($promottedMenu->unit_price,$promottedMenu->discount_price,$relatedPromo[$promottedMenu->id]->amount) }})">
                                                    
                                                    <p class="product-name-style">{{Str::limit($promottedMenu->name,20)}}
                                                        
                                                        @if(!blank($promottedMenu->product_info))
                                                        <a href="#exampleModal" wire:click.prevent="addToInfoModal({{$promottedMenu->id}})" class="product_info">{{ __('frontend.product_info') }}</a>
                                                        @endif
                                                    </p>
                                                    <p class="food-price-p with-color">{!! Str::limit(strip_tags($promottedMenu->description))!!}</p>
                                                    <p class="m-0">
                                                        <span class="special-offer"> <i class="fas fa-fire"></i> {{ $relatedPromo[$promottedMenu->id]->name }}</span>
                                                    </p>
                                                    <p class="food-price-p custom-design">
                                                        {{-- {{setting('currency_name')}} {{$promottedMenu['unit_price'] - $promottedMenu['discount_price']}} --}}
                                                        <span class="discount-price">{{setting('currency_name')}}{{ $promottedMenu->unit_price }}</span>
                                                        {{ currencyName(promoPrice($promottedMenu->unit_price,$promottedMenu->discount_price,$relatedPromo[$promottedMenu->id]->amount) )}}
                                                    </p>
                                                </a>
                                            </div>
                                            <div class="product-image-section">

                                                <a href="#variation-{{$promottedMenu->id}}" wire:click.prevent="addToCartPromoModal({{$promottedMenu->id}},{{ promoPrice($promottedMenu->unit_price,$promottedMenu->discount_price,$relatedPromo[$promottedMenu->id]->amount) }})">
                                                    <img class="menu-img" src="{{ $promottedMenu->image }}" alt="">
                                                    <i class="fa fa-plus menu-cart"></i>

                                                </a>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
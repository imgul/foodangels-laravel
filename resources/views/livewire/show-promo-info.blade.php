<div>



    <div id="listing-product-list" class="promo-header">

        @if(count($promottedMenus) >0  && !$promottedMenus->isEmpty())
        <h2 class="promo-heading">Best Deals</h2>
            <div class="container-fluid custom-container">
                <div class="row">
                    @foreach($promottedMenus as $promottedMenu)
                       <?php //  echo "<pre>"; print_r(asset($promottedMenu->product->media->file_name));  ?>

                        @if(auth()->user() )
                         @php
                            $ordersCount =  \App\Models\Order::where('user_id', auth()->user()->id)->where('promo_code', $promottedMenu->promo->id)->count();

                        @endphp
                        @if ( $ordersCount < $promottedMenu->promo->user_limit)
                            <div class="col-md-3">
                                <div class="style-2">
                                    <div class="tabs-container border-radius">
                                        <div class="tab-content food-price-tab" id="tab1a">
                                            <div class="product-description-section">
                                                <a href="#variation-{{$promottedMenu->product->id}}"
                                                   wire:click.prevent="addToCartPromoModal({{$promottedMenu->product->id}}, {{ promoPrice($promottedMenu->product->unit_price,$promottedMenu->product->discount_price,$promottedMenu->promo->amount) }})">
                                                    <p class="product-name-style">{{Str::limit($promottedMenu->product->name,20)}}
                                                    </p>
                                                    <p class="m-0">
                                                        <span class="special-offer"> <i class="fas fa-fire"></i> {{$promottedMenu->promo->name}}</span>
                                                    </p>
                                                    <p class="food-price-p custom-design">
                                                        <span class="discount-price">{{setting('currency_name')}}{{ $promottedMenu->product->unit_price }}</span>
                                                        {{ currencyName(promoPrice($promottedMenu->product->unit_price,$promottedMenu->product->discount_price,$promottedMenu->promo->amount) )}}
                                                    </p>
                                                </a>
                                            </div>
                                            <div class="product-image-section">
                                                <a href="#variation-{{$promottedMenu->product->id}}" wire:click.prevent="addToCartPromoModal({{$promottedMenu->product->id}},{{ promoPrice($promottedMenu->product->unit_price,$promottedMenu->product->discount_price,$promottedMenu->promo->amount) }})">
                                                       <img class="menu-img" src="{{ !isset($promottedMenu->product->media->file_name) ? asset('frontend/images/default/menuitem.png') : asset($promottedMenu->product->media->file_name) }}" alt="tesr">

                                                    <i class="fa fa-plus menu-cart"></i>
                                                </a>
                                            </div>
                                            <!-- You can add more sections for product details if needed -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @else
                            <div class="col-md-3">
                                <div class="style-2">
                                    <div class="tabs-container border-radius">
                                        <div class="tab-content food-price-tab" id="tab1a">
                                            <div class="product-description-section">
                                                <a href="#variation-{{$promottedMenu->product->id}}"
                                                   wire:click.prevent="addToCartPromoModal({{$promottedMenu->product->id}}, {{ promoPrice($promottedMenu->product->unit_price, $promottedMenu->product->discount_price, $promottedMenu->promo->amount) }})">
                                                    <p class="product-name-style">{{Str::limit($promottedMenu->product->name,20)}}
                                                    </p>
                                                    <p class="m-0">
                                                        <span class="special-offer"> <i class="fas fa-fire"></i> {{$promottedMenu->promo->name}}</span>
                                                    </p>
                                                    <p class="food-price-p custom-design">
                                                        <span class="discount-price">{{setting('currency_name')}}{{ $promottedMenu->product->unit_price }}</span>
                                                        {{ currencyName(promoPrice($promottedMenu->product->unit_price,$promottedMenu->product->discount_price,$promottedMenu->promo->amount) )}}
                                                    </p>
                                                </a>
                                            </div>
                                           <div class="product-image-section">
                                                <a href="#variation-{{$promottedMenu->product->id}}" wire:click.prevent="addToCartPromoModal({{$promottedMenu->product->id}},{{ promoPrice($promottedMenu->product->unit_price,$promottedMenu->product->discount_price,$promottedMenu->promo->amount) }})">

                                                        <img class="menu-img" src="{{ !isset($promottedMenu->product->media->file_name) ? asset('frontend/images/default/menuitem.png') : asset($promottedMenu->product->media->file_name) }}" alt="tesr">
                                                        <i class="fa fa-plus menu-cart"></i>

                                                </a>
                                            </div>


                                            <!-- You can add more sections for product details if needed -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

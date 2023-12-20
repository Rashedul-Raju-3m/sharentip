<?php
$cart_items = [];
if(Session::has('cart')){
    $cart_items = Session::get('cart');
}

$cart_total = [];
if(Session::has('cart_total')){
    $cart_total = Session::get('cart_total');
}

?>



@if(count($cart_items) > 0)

    @foreach($cart_items as $cart)
        <div class="product product-cart">
            <div class="product-detail">
{{--                <a href="{{route('single.product.details',$cart['product_slug'])}}" class="product-name">{{$cart['product_name']}}</a>--}}
                <a href="" class="product-name">{{$cart['item_name']}}</a>
                <div class="price-box">
                    <span class="product-quantity">{{$cart['item_quantity']}}</span>
                    <span class="product-price" style="margin-bottom: 0px;">{{$cart['item_price'].' = '}}</span>
                    <span class="product-price" style="margin-bottom: 0px;">&nbsp{{$cart['item_price']*$cart['item_quantity']}}</span>
                </div>
            </div>
            {{--<figure class="product-media">
                <a href="{{route('single.product.details',$cart['product_slug'])}}">
                    <img src="{{ asset('backend/image/ProProductImage').'/'.$cart['product_image']}}" alt="product" width="84"
                         height="94" />
                </a>
            </figure>--}}
{{--            <button class="btn btn-link btn-close" id="remove-cart-product" product_id="{{$cart['product_id']}}" data-href="{{route('web.cart.remove')}}">--}}
            <button class="btn btn-link btn-close" id="remove-cart-product" product_id="{{$cart['item_id']}}" data-href="">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endforeach
@endif


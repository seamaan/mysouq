<?php
$href = !empty($url) ? $url :route('product.addToCart',['id'=>$id]) ;
$name=\App\Product::find($id)->name;
$photo=\App\Product::find($id)->imagedefault();
?>
<a href="javascript:;" class="hidden-sm addToCart{{$id}}" onclick="addToCart({{$id}},'{{$href}}','{{$name}}','{{$photo}}')" title="{{trans('site.add_to_cart')}}">
    <i class="fa fa-shopping-cart p_cart{{$id}} "></i>
</a>
<i class="fa fa-spinner fa-spin spin_product{{$id}} hidden"></i>

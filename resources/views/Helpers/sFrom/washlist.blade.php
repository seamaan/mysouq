<?php
$attr=$attr?$attr:null;
$name=\App\Product::find($id)->name;
$photo=\App\Product::find($id)->imagedefault();
if(auth()->user()){
    $washlist = \App\Washlist::where('product_id', $id)->where('user_id', auth()->user()->id)->first();
    if (!$washlist and $attr==null) {
    $href = !empty($url) ? $url :route('product.getToWashlist',['id'=>$id]) ;
    $class='fa fa-heart-o';
    $title=trans('site.add_to_washlist');
    }elseif (!$washlist and $attr!=null) {
        if(in_array($id,$attr)){
            $href = 'done' ;
            $class='fa fa-heart';
            $title=trans('site.addedtowashlist');
        }else{
            $href = !empty($url) ? $url :route('product.getToWashlist',['id'=>$id]) ;
            $class='fa fa-heart-o';
            $title=trans('site.add_to_washlist');
        }
    }else{
        //$href = route('userwishlist') ;
        $href = 'done' ;
        $class='fa fa-heart danger';
        $title=trans('site.addedtowashlist');
    }
}else{
    if($attr!=null ){
       if(in_array($id,$attr)){
           //$href = route('washlist') ;
           $href = 'done' ;
           $class='fa fa-heart';
           $title=trans('site.addedtowashlist');
       }else{
            $href = !empty($url) ? $url :route('product.getToWashlist',['id'=>$id]) ;
            $class='fa fa-heart-o';
            $title=trans('site.add_to_washlist');
       }
    }else{
        $href = !empty($url) ? $url :route('product.getToWashlist',['id'=>$id]) ;
        $class='fa fa-heart-o';
        $title=trans('site.add_to_washlist');
    }
}
?>
<a href="javascript:;" class="hidden-sm addToWashlist{{$id}}" onclick="addToWashlist({{$id}},'{{$href}}','{{$name}}','{{$photo}}')" title="{{$title}}"><i class="{{$class}} washlist{{$id}}" ></i></a>


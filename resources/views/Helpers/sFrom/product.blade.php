<?php
$modal=!empty($modal)?$modal:null;
$product=!empty($model)?$model:null;
$washlist=Session::has('washlist') ? Session::get('washlist'):null;
$items=$washlist!=null?$washlist->items:null;
if($washlist!=null and $items!=null ){
    foreach($items  as $item) {
        $itemid[]=$item['item']['id'];
    }
}else{
    $itemid=null;
}
?>

<div class="item">
    <div class="col-item">

            <div class="photo">
                @if($modal)
                <div class="options-cart-round">
                    <button class="btn btn-default" data-toggle="modal" data-target="#myModal{{$product->id}}"
                            title="{{trans('site.view')}}">
                        <span class="fa fa-eye"></span>
                    </button>
                </div>
                @endif
                <a href="{{url('/'.'details/'.$product->id)}}">

                <img class="img-rounded img-responsive"
                     src="{{$product->imagedefault()}}" alt="Product Image"/>
                </a>
            </div>



        <div class="info" style="">
            <a href="{{url('/'.'details/'.$product->id)}}">
                <div class="row">
                    <div class="product-details col-md-6">
                        <h1>{{$product->trans('name')}}</h1>
                    </div>
                </div>
            </a>
            <div class="row">
                           <span class="price">
                             {{$product->trans('price')}}{!! money_code() !!}
                           </span>
                <div class="stars">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </div>

            </div>

            <div class="separator clear-left">

                <p class="btn-add">
                    {!!  sForm::cart($product->id,route('product.addToCart',['id'=>$product->id])) !!}
                </p>
                <p class="btn-details">
                    {!!  sForm::washlist($product->id,route('product.addToWashlist',['id'=>$product->id]),$itemid) !!}

                </p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@if($modal)
    <?php
    $imgs = $product->id > 0 ? \App\Product::find($product->id)->imagespath() : '';
    ?>
    <div class="modal fade" id="myModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                class="sr-only">{{trans('site.close')}}</span></button>


                    <div class="card">
                        <div class="container-fliud">
                            <div class="wrapper row">
                                <div class="preview col-md-6">
                                    @if(!empty($imgs) )
                                        <div id="gallery" class="simplegallery">
                                            <div class="content">
                                                <?php
                                                $i = 0;
                                                ?>
                                                @foreach($imgs as $img)
                                                    <?php
                                                    $i = $i + 1;
                                                    if (file_exists(base_path($img))) {
                                                        $imgdefault = \App\Image::where('thumb_url', $img)->first()->default;
                                                        $imgurl = \App\Image::where('thumb_url', $img)->first()->url;
                                                        $imgurl = url($imgurl);
                                                        $imgpath = $img;
                                                    } else {
                                                        $imgdefault = 1;
                                                        $imgurl = url(cp_url . '/img/noimage.jpg');
                                                        $imgpath = $img;
                                                    }

                                                    ?>
                                                    <img src="{{$imgurl}}" class="image_{{$i}}"
                                                         {{$imgdefault==1 ? '' : 'style="display:none"'}} alt=""/>
                                                @endforeach
                                            </div>

                                            <div class="clear"></div>

                                            <div class="thumbnailx">
                                                <?php
                                                $i = 0;
                                                ?>
                                                @foreach($imgs as $img)
                                                    <?php
                                                    $i = $i + 1;
                                                    if (file_exists(base_path($img))) {
                                                        $imgdefault = \App\Image::where('thumb_url', $img)->first()->default;
                                                        $imgurl = url($img);
                                                        $imgpath = $img;
                                                    } else {
                                                        $imgdefault = 1;
                                                        $imgurl = url(cp_url . '/img/noimage.jpg');
                                                        $imgpath = $img;
                                                    }

                                                    ?>
                                                    <div class="thumb">
                                                        <a href="#" rel="{{$i}}">
                                                            <img src="{{$imgurl}}" id="thumb_{{$i}}" alt=""/>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="details col-md-6">
                                    <h3 class="product-title">{{$product->trans('name')}}</h3>
                                    <div class="rating">
                                        <div class="stars">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                        <span class="review-no">41 reviews</span>
                                    </div>
                                    <p class="product-description">
                                        {{$product->trans('content')}}
                                    </p>
                                    <h4 class="price">{{trans('site.price')}}:
                                        <span> {{$product->trans('price')}} <i class="fa {{money_code()}}"></i></span></h4>

                                    <div class="action">
                                        <div class="pull-left">
                                            {!!  sForm::washlist($product->id,route('product.addToWashlist',['id'=>$product->id]),$itemid) !!}

                                            {!!  sForm::cart($product->id,route('product.addToCart',['id'=>$product->id])) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{trans('site.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#gallery').simplegallery({
            galltime: 400,
            gallcontent: '.content',
            gallthumbnail: '.thumbnail',
            gallthumb: '.thumb'
        });

    });
</script>

@endif



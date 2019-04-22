<?php
$categories = \App\Category::all();
$model='\App\\'.str_singular(ucfirst($name));
$tblname=str_singular($name);
$imgs= $id > 0 ? $model::find($id)->imagespath() :'';
//dd($imgs);
$i=0;
?>
<button type="button"  onClick="
        window.open('{{url('cpanel/fm')}}',
        'selectphoto',
        'width=800,height=600,scrollbars=0,resizable=0'
        );
        return false;"
        class="btn btn-info">
    {{trans('lang.image')}}
</button>
<input type="text" class="form-control hidden" name="imgbox" id="txtName">
<div class="row" id="images">
</div>

@if(!empty($imgs) )
    <div class="row">

        @foreach($imgs as $img)
            <?php
                 if (file_exists(base_path($img))) {
                     $imgdefault=\App\Image::where('thumb_url',$img)->first()->default;
                     $imgurl = url($img);
                    $imgpath=$img;
                } else {
                    $imgurl = url(cp_url . '/img/noimage.jpg');
                    $imgpath=$img;
                    $imgdefault='';

                }
            $i=$i+1;
            ?>
            <div class="image" id="image{{$i}}">
                <img  src="{{$imgurl}}" alt="Image preview" class="thumbnail" style="max-height: 100px">
                @if($imgpath)
                    <input  title="{{trans('site.default')}}" type="radio" {{$imgdefault==1 ? 'checked' : ''}} class="default"
                            onchange="makedefault('{{$id}}','{{$imgpath}}','{{$tblname}}','spin_load{{$i}}','spin_checked{{$i}}');"
                            value="1" name="default">

                <button title="{{trans('lang.delete')}}" type="button"
                        onclick="deletimg('{{$id}}','{{$imgpath}}','{{$tblname}}','image{{$i}}','spin_load{{$i}}');"
                        class="btn btn-danger btn-xs delete">
                    <i class=" fa fa-close"></i>
                </button>
                @endif
                <i class="fa fa-spinner hidden fa-xs fa-spin spin_load{{$i}} spin-pos"></i>
                <i class="fa fa-check fa-lg  {{$imgdefault==1 ? '' : 'hidden'}} spin_checked{{$i}} spin-pos"></i>


            </div>
        @endforeach
    </div>
@else

@endif
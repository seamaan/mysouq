
<?php
$name = !empty($name) ? $name : '';
$url = !empty($url) ? $url : url(cp_url.'/img/noimage.jpg');
?>

<div class="imageupload panel panel-default" style="border: 0px">
    <div class="file-tab panel-body">
        <label class="btn btn-default btn-file">
            <span>{{ trans('lang.browse_img') }}</span>
            {!! Form::file($name, ['multiple' => 'multiple','id'=>'images']) !!}
            <hr>
            <div id="images-to-upload">

            </div><!-- end #images-to-upload -->

            <hr>

        </label>
        <button type="button" class="btn btn-default">{{trans('lang.remove')}}</button>
    </div>
</div>
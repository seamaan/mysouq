<?php
if (App\Admin::count()==0){
    \App\Admin::create([
        'site_name'=>'HamadaSoft',
        'admin_id'=>1,
        'maintenance'=>'open',
    ]);
}
?>
@extends('cpanel.home')
@section('title')
    {{trans('lang.general_settings')}}
@stop
@section('css')
<style>

    .close{
        float: left;
    }
    /* Profile Content */
    .profile-content {
        padding: 20px;
        background: #fff;
        min-height: 500px;
    }
    .picture-container {
        position: relative;
        cursor: pointer;
        text-align: center;
    }
    .picture{
        width: 106px;
        height: 106px;
        background-color: #999999;
        border: 4px solid #CCCCCC;
        color: #FFFFFF;
        border-radius: 50%;
        margin: 0px auto;
        overflow: hidden;
        transition: all 0.2s;
        -webkit-transition: all 0.2s;
    }
    .picture:hover{
        border-color: #2ca8ff;
    }
    .picture input[type="file"] {
        cursor: pointer;
        display: block;
        height: 100%;
        left: 0;
        opacity: 0 !important;
        position: absolute;
        top: 0;
        width: 100%;
    }

    .picture-src{
        /*width: 100%;*/
        max-height: 100%;
    }
</style>
@endsection
@section('content')
    {!! bsForm::open(['title'=>trans('lang.general_settings'),'files' => true])!!}
    <div class="col-md-3">
        <div class="picture-container">
            <div class="picture">
                <img class="picture-src" src="{{site()->image()}}" alt="" title="" id="wizardPicturePreview">
                <input name="image" type="file" onchange="readURL(this);"   id="wizard-picture">
            </div>
            <div class="picture-title">{{trans('site.change',['var'=>trans('site.image')])}} {{trans('lang.Logo')}}</div>
        </div>

    </div>

    <div class="col-md-9">

    {!! bsForm::text('site_name',site()->trans('site_name')) !!}
    {!! bsForm::text('site_mail',site()->site_mail) !!}
    {!! bsForm::text('paymax',site()->paymax)!!}
    {!! bsForm::radio('maintenance',[
        'open'=>trans('lang.open'),
        'close'=>trans('lang.close'),
    ],site('maintenance')) !!}
    {!! bsForm::translate(function($form,$lang) {
                $form->textarea('message_maintenance',site()->trans('message_maintenance',$lang),[
                             'class'=>'form-control editor',
                             'id'=>'ckview',
                             ]);

                })
    !!}

        <div class="form-group{{ $errors->has('money_code') ? ' has-error' : '' }}">
            <label>{{ trans('lang.money_code') }}</label>
            <div class="input-group">
                <div class="iCheck">
                    @foreach(\App\Currency::all() as $row)
                        <label>
                       <input type="radio" name="money_code" class="icheck" {{site('money_code')==$row->id ? 'checked':''}} value="{{$row->id}}">

                        <i class="fa {{money_code()}}"></i>  {{$row->trans('name')}}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    {!! bsForm::text('facebook',site('facebook')) !!}
    {!! bsForm::text('twitter',site('twitter')) !!}
    {!! bsForm::textarea('site_desc',site('site_desc')) !!}
    {!! bsForm::textarea('keywords',site('keywords')) !!}
    </div>


    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}

@endsection
@section('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
                }
                reader.readAsDataURL(input.files[0]);
            }

        }
    </script>
@endsection
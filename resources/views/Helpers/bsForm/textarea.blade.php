<?php
$value=!is_null($value) ? $value : old($name);
?>
<div class="form-group {{$errors->has($name) ? ' has-error' :''}} ">
    <label class="control-label" for="{{$name}}">
            @if ($errors->has($name))
            <i class="fa fa-times-circle-o"></i>
            @endif
            {{trans('lang.'.trim($name,'[]'))}}
    </label>
    {!! Form::textarea($name,$value,array_merge($attributes,[
    'class'=>'form-control',
    'placeholder'=>trans('lang.info')])) !!}
    @if($errors->has($name))
        <span class="help-block">{{$errors->first($name)}}</span>
    @endif
</div>
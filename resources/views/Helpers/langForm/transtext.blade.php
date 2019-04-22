
<?php
$attributes = !empty($attributes) ? $attributes : [];
$value = !empty($value) ? $value : old($name);
$name1 = $name;
$name = $name.$lang_id;
?>
<div class="form-group">
    <div class="col-sm-10">
        {!! Form::text($name,$value,array_merge([
           'class'=>'form-control',
           'id'=>'inputtext',
           'placeholder' => trans('lang.'.$name1)
           ],$attributes)) !!}
    </div>
</div>



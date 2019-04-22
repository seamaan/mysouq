
<?php
   $attributes = !empty($attributes) ? $attributes : [];
   $value = !empty($value) ? $value : old($name);
   $name1 = $name;
   $name = $name.$lang_id;
?>
{!! Form::text($name,$value,array_merge([
     'class'=>'form-control',
     'placeholder' => trans('lang.'.$name1)
     ],$attributes)) !!}




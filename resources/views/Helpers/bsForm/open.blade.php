<!-- general form elements disabled -->
<?php
$title=isset($options['title']) ? $options['title'] : '';
?>

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">{{$title}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! Form::open(array_except($options,'title')) !!}
            <!-- text input -->



@if (isset($options['submit'])|| isset($options['reset']))
<div class="box-footer">
    @if($options['submit'])
    <button type="submit" class="btn btn-info ">{{trans('lang.save')}}</button>
    @endif
    @if ($options['reset'])
    <button type="reset" class="btn btn-default pull-right" >{{trans('lang.reset')}}</button>
    @endif
</div>
@endif

{!! Form::close() !!}
</div>
<!-- /.box-body -->
</div>
<!-- /.box -
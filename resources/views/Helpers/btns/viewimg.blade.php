<?php
$href = !empty($url) ? $url : url()->current().'/'.$id.'/edit';
$appmodelname='\App\\'.ucfirst(str_singular($modelname));
$model=!empty($appmodelname) ? $appmodelname::find($id) : url()->current();
//$image=!empty($model->image) ? url($model->image) : url('public/cpanel/img/noimage.jpg');
$image=$appmodelname::find($id)->image();
?>
@if(Auth::guard('admin')->user()->job =='admin' || Auth::guard('admin')->user()->can('view') )
	@if(!empty($attr))

		<a href="javascript:;" data-toggle="modal" data-target="#myModal{{$model->id}}"

		@foreach($attr as $key => $value)
			{{ $key }}="{{ $value }}" &nbsp

		@endforeach

		title="{{ trans('lang.view') }}" class="fa fa-eye fa-fw fa-lg"></a>

	@else
		<a href="javascript:;" class="btn btn-success btn-xs " title="{{trans('lang.view')}}"  data-toggle="modal" data-target="#viewModal{{$model->id}}"><i class="fa fa-eye"></i> </a>
	@endif
	<div class="modal fade" id="viewModal{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					@include('cpanel.'.$modelname.'.show')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default " data-dismiss="modal">{{trans('lang.cancel')}}</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


@endif
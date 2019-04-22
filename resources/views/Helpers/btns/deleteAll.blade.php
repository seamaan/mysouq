@php
	$adminId=Auth::guard('admin')->user()->id;
	$admins=\App\Admin::all();
@endphp
@if(Auth::guard('admin')->user()->job =='admin' || Auth::guard('admin')->user()->can('deleteall') )

<button  class="btn btn-danger" data-toggle="modal" data-target="#myModal" title="{{trans('lang.delete')}}" ><i class="fa fa-trash fa-sm "></i> {{trans('lang.delete_selected')}}</button>
@php
	$name=empty($name) ? trans('lang.row') :$name ;
@endphp
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{{trans('lang.delete_sure')}}</h4>
			</div>
			<div class="modal-body">
				<p>{{trans('lang.delete_msg',['var'=>trans('lang.'.$name)])}}</p>
			</div>
			<div class="modal-footer">

				{!! Form::open(['id'=>'delete_form','method'=>'delete']) !!}
				<button type="submit" class="btn btn-danger" form="delete_form">{{trans('lang.delete_selected')}}</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">{{trans('lang.cancel')}}</button>

				{!! Form::close() !!}

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif





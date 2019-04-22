@php
	$href = !empty($url) ? $url : url()->current().'/'.$id;
    $adminId=Auth::guard('admin')->user()->id;
    $admins=\App\Admin::all();
@endphp
@if(Auth::guard('admin')->user()->job =='admin' || Auth::guard('admin')->user()->can('delete') )

	<a href="javascript:;" class="btn btn-danger btn-xs delete_btn{{$id}}" title="{{trans('lang.delete')}}" data-toggle="modal" data-target="#deletemodal{{$id}}"><i class="fa fa-trash-o"></i></a>
	<!-- Button trigger modal -->

	@php
		$name=empty($name) ? trans('lang.row') :$name ;
	@endphp

	<div class="modal fade" id="deletemodal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">{{trans('lang.delete_sure')}}</h4>
				</div>
				<div class="modal-body">
					<p>{{trans('lang.delete_msg',['var'=>$name])}} </p>
				</div>
				<div class="modal-footer">
					{!! Form::submit(trans('lang.delete'),['form'=>'delete_form'.$id,'class'=>'btn btn-danger','name'=>'delete'.$id]) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">{{trans('lang.cancel')}}</button>
					{!! Form::open(['url'=>$href,'method'=>'delete','id'=>'delete_form'.$id]) !!}
					{!! Form::close() !!}

				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endif

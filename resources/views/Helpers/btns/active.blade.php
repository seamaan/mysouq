@php
	$href = !empty($url) ? $url : url()->current().'/'.$id;
    $adminId=Auth::guard('admin')->user()->id;
    $admins=\App\Admin::all();
    $model='\App\\'.ucfirst(str_singular($tblname));
	$row=$model::find($id);
	$msg=$row->active==0?trans('lang.Active'):trans('lang.deActive')
@endphp
@if(Auth::guard('admin')->user()->job =='admin' || Auth::guard('admin')->user()->can('active') )

	<a href="javascript:;" class="btn {{$row->active==0?'btn-info':'btn-danger'}}  btn-xs active_btn{{$id}}" title="{{trans('lang.Active')}}" data-toggle="modal" data-target="#activemodal{{$id}}">
		<i class="fa fa-key"></i> {{$row->active==0?trans('lang.Active'):trans('lang.deActive')}}
	</a>
	<!-- Button trigger modal -->

	@php
		$name=empty($name) ? trans('lang.row') :$name ;
	@endphp

	<div class="modal fade" id="activemodal{{$id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">{{trans('lang.sure_msg')}}</h4>
				</div>
				<div class="modal-body">
					<p>{{trans('lang.active_msg',['msg'=>$msg,'var'=>$name])}} </p>
				</div>
				<div class="modal-footer">
					{!! Form::submit(trans('lang.Sure'),['form'=>'active_form'.$id,'class'=>'btn btn-info','name'=>'active'.$id]) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">{{trans('lang.cancel')}}</button>
					{!! Form::open(['url'=>$href,'method'=>'put','id'=>'active_form'.$id]) !!}
					{!! Form::close() !!}

				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endif

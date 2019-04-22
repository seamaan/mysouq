<?php 
$href = !empty($url) ? $url : url()->current().'/'.$id.'/edit';
$adminId=Auth::guard('admin')->user()->id;
$admins=\App\Admin::all();
?>
@if(Auth::guard('admin')->user()->job =='admin' || Auth::guard('admin')->user()->can('edit') )
	@if(!empty($attr))

		<a href="{{ $href }}" 

		@foreach($attr as $key => $value)
		{{ $key }}="{{ $value }}" &nbsp

		@endforeach

		title="{{ trans('lang.edit') }}" class="fa fa-edit fa-fw fa-lg"></a>

	@else
		<a href="{{ $href }}" class="btn btn-info btn-xs" title="{{trans('lang.edit')}}"><i class="fa fa-edit"></i></a>
	@endif


@endif



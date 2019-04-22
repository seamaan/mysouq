<?php 
	$href = !empty($url) ? $url : url()->current().'/create';
$adminId=Auth::guard('admin')->user()->id;
$admins=\App\Admin::all();
?>
@if(Auth::guard('admin')->user()->job =='admin' || Auth::guard('admin')->user()->can('create') )

 					@if(!empty($attr))
						<a href="{{ $href }}"
						@foreach($attr as $key => $value)
							{{ $key }}="{{ $value }}" &nbsp
						@endforeach
						title="{{trans('lang.add')}}"
						>
						<i class="fa fa-plus fa-fw "></i>
						{{ trans('lang.create') }}</a>
					@else
						<a href="{{ $href }}" class="btn btn-success" title="{{trans('lang.new')}}">
							<i class="fa fa-plus fa-fw "></i>
							{{ trans('lang.create') }}
						</a>
					@endif
@endif



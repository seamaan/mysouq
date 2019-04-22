	<a href="javascript:;" class="btn btn-success btn-xs " title="{{trans('lang.view')}}"  data-toggle="modal" data-target="#viewModal{{$model->id}}">{!! $title !!}</a>
	<div class="modal fade" id="viewModal{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					@include('cpanel.'.$modelname.'.custom')
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default " data-dismiss="modal">{{trans('lang.cancel')}}</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->



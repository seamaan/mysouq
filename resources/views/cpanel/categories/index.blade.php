@extends('cpanel.index')
@section('title') {{ trans('lang.categories') }}  @endsection
@section('menu') {!! getBreadcrumbs('category')->index !!} @endsection

@section('css')
    <!-- 2 load the theme CSS file -->
    @endsection
<!-- 3 setup a container element -->

@section('content')
    <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{trans('lang.manage',['var'=>trans('lang.categories')])}}</h3>

                <div class="pull-right">
                    {!! Btn::create() !!}
                </div>
            </div>

            <!-- /.box-header -->

            <div class="box-body">
                <a href="" class="btn btn-info edit_dep showbtn_control hidden" ><i class="fa fa-edit"></i> {{ trans('lang.edit') }}</a>
                <a href="" class="btn btn-danger delete_dep showbtn_control hidden"  data-toggle="modal" data-target="#delete_bootstrap_modal" ><i class="fa fa-trash"></i> {{ trans('lang.delete') }}</a>
                <div id="jstree"></div>

            </div>
    </div>
<!-- 4 include the jQuery library -->
<!-- 5 include the minified jstree source -->
@push('jas')
    <div id="delete_bootstrap_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('lang.delete') }}</h4>
                </div>
                {!! Form::open(['url'=>'','method'=>'delete','id'=>'form_Delete_department']) !!}
                <div class="modal-body">
                    <h4>
                        {{ trans('lang.delete_sure') }} <span id="dep_name"></span>
                    </h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">{{ trans('lang.cancel') }}</button>
                    {!! Form::submit(trans('lang.ok'),['class'=>'btn btn-danger']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <script>
    $(function () {
        $('#jstree').jstree({
            "core" : {
                'data' :{!! load_dep() !!},
                "themes" : {
                    "variant" : "large"
                }
            },
            "checkbox" : {
                "keep_selected_style" : true
            },
            "plugins" : [ "wholerow" ]
        });
        $('#jstree').on('changed.jstree',function(e,data){
            var i , j , r = [];
            var  name = [];
            for(i=0,j = data.selected.length;i < j;i++)
            {
                r.push(data.instance.get_node(data.selected[i]).id);
                name.push(data.instance.get_node(data.selected[i]).text);
            }
            $('#form_Delete_department').attr('action','{{ url(cp.'categories') }}/'+r.join(', '));
            $('#dep_name').text(name.join(', '));
            if(r.join(', ') != '')
            {
                $('.showbtn_control').removeClass('hidden');
                $('.edit_dep').attr('href','{{ url(cp.'categories') }}/'+r.join(', ')+'/edit');
            }else{
                $('.showbtn_control').addClass('hidden');
            }
        });
    });

</script>
@endpush
@endsection


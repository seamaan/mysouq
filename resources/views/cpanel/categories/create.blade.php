@extends('cpanel.index')
@section('title'){{trans('lang.add',['var'=>trans('lang.category')])}}@endsection
@section('menu') {!! getBreadcrumbs('category')->create !!} @endsection
@section('css')
<style>

</style>
@endsection
@section('content')

    {!! bsForm::open(['route'=>'categories.store','title'=>trans('lang.add',['var'=>trans('lang.category')]),'files'=>true]) !!}
    {!! bsForm::translate(function($form){
           $form->text('name');
           $form->textarea('content','',['class'=>'editor form-control ','id'=>'ckview',]);

     }) !!}
    @push('jas')
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
                    "keep_selected_style" : false
                },
                "plugins" : [ "wholerow" ]
            });
            $('#jstree').on('changed.jstree',function(e,data){
                var i , j , r = [];
                for(i=0,j = data.selected.length;i < j;i++)
                {
                    r.push(data.instance.get_node(data.selected[i]).id);
                }
                $('.parent_id').val(r.join(', '));

                if(r.join(', ') != '')
                {
                    $('#parent_none').removeClass('btn-info');
                }
                $('#parent_none').on('click',function(e,data){
                    $('.parent_id').val('0');
                    $(this).addClass('btn-info');
                    //$('#'+r.join(', ')).attr("aria-selected","false");
                    $('#'+r.join(', ')).unbind();
                    $("#jstree").jstree().deselect_all(true);
                    //$("#jstree").jstree().select_node(r.join(', '));

                });



            });
        });
    </script>
    @endpush
    <div class="form-group">
        <label for="category" class="control-label">{{ trans('lang.'.trim('main_category','[]')) }}</label>
        <input type="hidden" name="parent" class="parent_id" value="">
        <button class="btn btn-default" id="parent_none" type="button">{{trans('lang.none')}}</button>

        <div id="jstree"></div>
    </div>
    {!! bsForm::image('categories') !!}

    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}
@endsection
@section('js')
    @endsection

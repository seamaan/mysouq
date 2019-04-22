<?php
//$model=App\Category::find($category->id);
//$img=!empty($model->image) ? url($model->image) : url('public/cpanel/img/noimage.jpg');
$value = isset($model->parent_id) ? App\Category::find($model->parent_id)->id : '';
$deps=App\Category::all();
?>
@extends('cpanel.index')
@section('title'){{trans('lang.update',['var'=>$category->name])}}@endsection
@section('menu') {!! getBreadcrumbs('category',$category->id)->edit !!}  @endsection

@section('content')

    @push('jas')
    <script>
        $(function () {
            $('#jstree').jstree({
                "core" : {
                    'data' :{!! load_dep($category->parent_id,$category->id) !!},
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

    {!! bsForm::open(['route'=>['categories.update',$category->id],'method'=>'put','title'=>trans('lang.update',['var'=>$category->name])]) !!}

    {!! bsForm::translate(function($form,$lang) use($category){
             $form->text('name',$category->trans('name',$lang));
             $form->textarea('content',$category->trans('content',$lang),[
                          'class'=>'form-control editor',
                          'id'=>'ckview',
                          ]);

             })
             !!}

    <div class="form-group">
        <label for="category" class="control-label">{{ trans('lang.'.trim('main_category','[]')) }}</label>
        <input type="hidden" name="parent" class="parent_id" value="{{ $category->parent_id }}">
        <button class="btn {{$category->parent_id > 0 ? 'btn-default' : 'btn-info' }}" id="parent_none" type="button">{{trans('lang.none')}}</button>



        <div id="jstree"></div>
    </div>

    {!! bsForm::image('categories',$category->id) !!}

    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}
@endsection
@section('js')
    <script>
        var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";

        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
         $('#lfm').filemanager('image', {prefix: route_prefix});
        $('#lfm2').filemanager('file', {prefix: route_prefix});
    </script>
    <script>
        $(document).ready(function(){

            // Define function to open filemanager window
            var lfm = function(options, cb) {
                var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
                window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
                window.SetUrl = cb;
            };

            // Define LFM summernote button
            var LFMButton = function(context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="note-icon-picture"></i> ',
                    tooltip: 'Insert image with filemanager',
                    click: function() {

                        lfm({type: 'image', prefix: '/laravel-filemanager'}, function(url, path) {
                            context.invoke('insertImage', url);
                        });

                    }
                });
                return button.render();
            };

            // Initialize summernote with LFM button in the popover button group
            // Please note that you can add this button to any other button group you'd like
            $('#summernote-editor').summernote({
                toolbar: [
                    ['popovers', ['lfm']],
                ],
                buttons: {
                    lfm: LFMButton
                }
            })
        });
    </script>
@endsection
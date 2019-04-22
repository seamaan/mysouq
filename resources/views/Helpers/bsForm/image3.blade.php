<?php
$name = !empty($name) ? $name : 'filepath';
$img = !empty($url) ? url($url) : url(cp_url.'/img/noimage.jpg');
$default=!empty($default) ? 1 : 0;
//dd(trans('lang.'.$name));
?>

<div class="form-horizontal">
            <div class="form-group ">

                <div class="col-sm-10" style="text-align: right">
                    <input id="thumbnail" class="hide" type="text" name="{{$name}}">
                    @if ($url)
                        <img  src="{!! $img !!}" alt="Image preview" class="thumbnail" style="max-height: 150px">
                    @endif
                    <img id="holder" class="thumbnail" style="margin-top:15px;max-height:150px;">
                </div>
                <div class="col-sm-2" style="text-align: right">
                    <label class="control-label">
                             {{trans('lang.'.$name)}}
                    </label>
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="width: 100%">
                        <i class="fa fa-picture-o"></i> {{trans('lang.'.$name)}}
                    </a>
                </div>
            </div>

    </div>
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
<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" url="{{ url('/') }}" cp-url="{{url(cp)}}">
<input type="hidden" id="token" value="{{ csrf_token() }}">
<head>
    <meta charset="utf-8">
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>  لوحة التحكم  | @yield('title')</title>
    <link rel="stylesheet" href="{{$cpanelcss}}bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{$cpanelcss}}font-awesome.min.css">
    <link rel="stylesheet" href="{{$cpanelcss}}dropzone.css">
    <link rel="stylesheet" href="{{$cpanelcss}}AdminLTE{{strtoupper(getDir('-'))}}.min.css">
    <link rel="stylesheet" href="{{$cpanelcss}}sweetalert.css">
    <script src="{{$cpaneljs}}sweetalert2.all.js"></script>
@yield('css')
<STYLE>
    .thumbnail{
        width: auto;
        height: 100%;
    }
    .flag{
        height: 90px;
        width: 120px;
        margin-bottom: 3px;
        overflow: hidden;
        padding: 5px !important;

    }
</STYLE>

<!-- Morris chart -->
</head>

<body>
@include('cpanel.layouts.inc.message')

<div class="panel panel-primary" style="height:100%;border: none;">
    <div class="panel-heading" style="height: 50px">
       <div class="pull-right dis-type hidden">
           <button type="button"  class="btn btn-default"><i class="fa fa-list"></i> </button>
           <button type="button"  class="btn btn-default"><i class="fa fa-th"></i> </button>
       </div>
       <div class="pull-left">
           <button type="button"  data-toggle="modal" data-target="#addfolder" class="btn btn-info">
               <i class="fa fa-plus"></i> <i class="fa fa-folder-o"></i></button>
           <button type="button" id="uploadphoto" data-toggle="modal" data-target="#uploadimage" class="btn btn-info hidden">
               <i class="fa fa-upload"></i></button>


           <button type="button" onclick="SetName();" class="hidden btn bg-orange choos">
               <i class="fa  fa-check-square-o"></i> {{trans('lang.select')}}</button>
           <button type="button" onclick="deletsetlect();" class="hidden btn btn-danger choos">
               <i class="fa  fa-trash"></i> {{trans('lang.delete')}}
               <i class="fa fa-spinner hidden fa-spin spin_del"></i>
           </button>
       </div>

    </div>
    <div class="panel-body" style="height:440px;overflow: auto; ">
    <div class="col-xs-9">
        <div class="tab-content" id="myTabContent">
            <div class="row result">
                {{--{!! includeimages("public/uploads") !!}--}}
                @include('cpanel.fm.allphoto')

                <div class="tab-pane fade show active" id="contenthome" role="tabpanel"
                     aria-labelledby="tabhome">
                    home
                </div>
            </div>
            <i class="fa fa-spinner hidden fa-spin fa-2x pull-right spin_dep"></i>

        </div>
    </div>
    <div class="col-xs-3">
        <ul class="nav flex-column">
            <li class="nav-item"  onclick=changeTab("tab0","0")>
                <a class="nav-link active" id="tabhome" data-toggle="tab"
                   href="#contenthome" role="tab" aria-controls="home"
                   aria-selected="true"><i class="fa fa-folder folder0"></i>{{trans('lang.home')}}</a>
            </li>
            @foreach(\App\Album::where('parent_id',0)->get() as $key=>$album)
                <li class="nav-item" onclick=changeTab("tab{{$album->id}}","{{$album->id}}")>
                    <a  class="nav-link {{$key==0 ?'active' :''}}" id="tab{{$album->id}}" data-toggle="tab"
                       href="#content{{$album->id}}" role="tab" aria-controls="home"
                       aria-selected="true"><i class="fa fa-folder folder{{$album->id}}"></i> {{$album->trans('name')}}</a>
                </li>
            @endforeach
        </ul>
    </div>
    </div>

<div class="modal fade" id="addfolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route'=>'albums.store','title'=>trans('lang.add',['var'=>trans('lang.album')]),'files'=>true]) !!}
                {{--{!! bsForm::translate(function($form){--}}
                      {{--$form->text('name');--}}
                  {{--}) !!}--}}
                <div class="form-group {{$errors->has('name') ? ' has-error' :''}} ">
                    <label class="control-label" for="name">
                        @if ($errors->has('name'))
                            <i class="fa fa-times-circle-o"></i>
                        @endif
                        {{trans('lang.'.trim('name','[]'))}}
                    </label>
                {!! Form::text('name',old('name'),['class'=>'form-control'])!!}
                    @if($errors->has('name'))
                        <span class="help-block">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="box-footer">
                        <button type="submit" class="btn btn-info ">{{trans('lang.save')}}</button>
                        <button type="reset" class="btn btn-default pull-right" >{{trans('lang.reset')}}</button>
                </div>
                {!! Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadimage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form action="{{ url('cpanel/photo/upload') }}" enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                    <input type="hidden" id="albumid" name="albumid" value="">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <div class="panel-footer" style="height: 40px">
        <button type="button" onclick="SetName();" class="hidden btn bg-orange choos"><i
                    class="fa  fa-check-square-o"></i> {{trans('lang.select')}}</button>
    </div>

</div>

<script src="{{$cpaneljs}}jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{$cpaneljs}}bootstrap.min.js"></script>
<script src="{{$cpaneljs}}dropzone.js"></script>
<script>
    $(document).on('click','label.flag',function (e) {
        //$('label.flag').addClass('btn-default').removeClass('btn-primary');
        $(this).toggleClass('btn-primary');
        $('.choos').removeClass('hidden');
    });
</script>
<script type="text/javascript">
    function changeTab(tabId,id){
        var url=$('html').attr('cp-url')+'/processtabs';
        var token=$('#token').val();
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data:{'id':id,'_token':token},
            cache: false,
            beforeSend:function () {
                $('.spin_dep').removeClass('hidden');
                $('#uploadphoto').removeClass('hidden');
                $('#albumid').val(id);
            },
            success: function(data){
                if(data !='false')
                {
                    $('.result').empty();
                    $('.result').prepend(data);
                    $('.fa-folder').removeClass('fa-folder-open');
                    $('.folder'+id).addClass('fa-folder-open');

                }else {
                    $('.result').empty();
                    $('.result').prepend('no data');

                }
                $('.spin_dep').addClass('hidden');
                $('.dis-type').removeClass('hidden');

            }
        });
    }
</script>
<script type="text/javascript">
    Dropzone.options.myDropzone = {
        paramName: 'file',
        maxFilesize: 5, // MB
        maxFiles: 20,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
//            addRemoveLinks: true,
//            removedfile: function(file) {
//                console.log(file.name);
//            },
        init: function () {

            this.on("success", function (file, response) {
                var a = document.createElement('input');
                a.className = "iCheck";
                a.type = "checkbox";
                a.value = response;
                a.name = "image[]";
                a.id="img";
                file.previewTemplate.appendChild(a);

                var removeButton = Dropzone.createElement("<i class='fa fa-close btn btn-danger'>");
                var _this = this;
                removeButton.addEventListener("click", function (e) {
                    // Make sure the button click doesn't submit the form:
                            console.log('{{url('/public/uploads')}}'+'/'+response)
                    var filename = response;
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('cpanel/photo/deleteImg') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                        },
                        data: {'filename': filename},
                        dataType: 'html',
                        success: function (data) {
                            $("#msg").html(data);
                        }
                    });

                    // Remove the file preview.
                    _this.removeFile(file);
                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.
                });
                file.previewElement.appendChild(removeButton);

                console.log(response)
                $('#uploadimage').modal('hide');
                $('.result').empty();
                $('.result').prepend(response);

            });

        }
    };

    //Flat red color scheme for iCheck
</script>
</body>

</html>
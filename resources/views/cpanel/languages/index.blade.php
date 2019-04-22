@extends('cpanel.index')
@section('title')
    {{trans('lang.languages')}}
@stop
@section('menu') {!! getBreadcrumbs('language')->index !!} @endsection

@section('css')
    <style>
        .nav-tabs>li{
            float: right;
        }
        .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            float: right;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <div class="box-header">

            <div>
                <a href="{{url()->current().'/create'}}" class="btn btn-primary btn-sm"> <i
                            class="fa fa-plus"></i> {{trans('lang.create')}}</a>
                <button type="submit" form="delete_form" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> {{trans('lang.delete_selected')}}</button>

                {!! Form::open(['url'=>'cpanel/languages/delete','method'=>'delete','id'=>'delete_form','class'=>'hidden']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered table-striped ">
                <thead>
                <tr>
                    <th> <input type="checkbox" id="checkall"  /></th>
                    <th>{{trans('lang.name')}}</th>
                    <th>{{trans('lang.flag')}}</th>
                    <th>{{trans('lang.code')}}</th>
                    <th>{{trans('lang.direction')}}</th>
                    <th>{{trans('lang.default')}}</th>
                    <th>{{trans('lang.control')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($langs as $language)
                    <?php
                    if($language->default ==1)
                        {
                         $modal='';
                         $disabled='disabled';
                         $href='javascript:;';
                        }else
                        {
                         $modal='modal';
                         $disabled='';
                         $href='#delete'.$language->id;
                        }
                    ?>
                    <tr class="{{$language->default ==1 ? trans('success') : ''}}">


                        <td><input type="checkbox" value="{{$language->id}}" name="delete[]" form="delete_form"></td>
                        <td>{{$language->name}}</td>
                        <td><img src="{{flag($language->id)}}"></td>
                        <td>{{$language->code}}</td>
                        <td>{{trans('lang.'.$language->direction)}}</td>
                        <td>{{$language->default ==1 ? trans('lang.default') : '--'}}</td>
                        <td>
                            {!! btnEdit($language->id) !!}
                            <a href="#translate-{{$language->id}}" data-toggle="modal"><i
                                        class="fa fa-cog fa-lg"></i></a>
                            <div class="modal fade" id="translate-{{$language->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">{{$language->name}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div>

                                                <!-- Nav tabs -->
                                                <?php
                                                $filesArray = glob(base_path('resources/lang/' . $language->code . '/*.php'));

                                                ?>
                                                <ul class="nav nav-tabs" role="tablist">
                                                    @foreach($filesArray as $index=>$file)
                                                        <?php
                                                        $filePath = $file;
                                                        $fileNameArray = explode('/', $filePath);
                                                        $fileName = explode('/', $filePath)[(count($fileNameArray)) - 1];

                                                        ?>
                                                        <li role="presentation" class="{{$index==0 ?'active' : ' ' }}">
                                                            <a href="#content_{{$index}}-{{$language->id}}"
                                                               aria-controls="content_{{$index}}-{{$language->id}}" role="tab"
                                                               data-toggle="tab">
                                                                {{$fileName}}</a></li>
                                                    @endforeach
                                                </ul>

                                                {!! Form::open(['url'=>cp.'languages/'.$language->id.'/translate','id'=>'translate_form_'.$language->id]) !!}
                                            <!-- Tab panes -->
                                                <div class="tab-content" style="direction: rtl;text-align: right">


                                                    @foreach($filesArray as $index=>$file)
                                                        <?php
                                                        $filePath = $file;
                                                        $fileName = explode('/', $filePath)[(count($fileNameArray)) - 1];
                                                        $fileContent= include ($filePath);



                                                        ?>
                                                        {!! Form::hidden('files_'.$index,$filePath) !!}
                                                        <div role="tabpanel" class="tab-pane {{$index==0 ? 'active' :'' }}" id="content_{{$index}}-{{$language->id}}">
                                                            <div class="alert" style="max-height: 400px;overflow: auto;">
                                                                @foreach($fileContent as $key=>$content)
                                                                    <div class="row">
                                                                        <div class="col-xs-4">
                                                                            <div class="form-control" style="width: 100%" >
                                                                                {{$key}}
                                                                            </div>
                                                                            <br />
                                                                            <br />
                                                                        </div>
                                                                        <div class="col-xs-8">
                                                                            {!! Form::hidden('content_key_'.$index.'[]',$key) !!}
                                                                            <input name="content_value_{{$index}}[]" type="text" class="form-control" value="{{$content}}" style="width: 100%">
                                                                            <br />
                                                                            <br />
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                </div>
                                                {!! Form::close() !!}

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" form="translate_form_{{$language->id}}" class="btn btn-primary">{{trans('lang.save')}}</button>
                                            <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">{{trans('lang.close')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a class="btn btn-danger" data-toggle="{{$modal}}"  href="{{$href}}" {{$disabled}}>
                                {{trans('lang.delete')}}
                            </a>


                        </td>
                    </tr>


                    <div class="modal fade" id="delete{{$language->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">{{trans('lang.delete_sure')}}</h4>
                                </div>
                                <div class="modal-body">
                                   {{trans('lang.delete_msg',['var'=>$language->name])}}
                                </div>
                                <div class="modal-footer">
                                    {!! form::submit(trans('lang.delete'),['class'=>'btn btn-danger','form'=>'delete_lang'.$language->id ]) !!}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('lang.cacele')}}</button>


                                </div>
                            </div>
                        </div>
                    </div>

                    {!! form::open(['url'=>'cpanel/languages/'.$language->id,'method'=>'delete','id'=>'delete_lang'.$language->id,'class'=>'hidden']) !!}
                    {!! form::close() !!}

                @endforeach

                </tbody>

            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection
@section('js')
    <script>
        $(document).on('change','#checkall',function (event) {
            if(this.checked){
             $('input[type="checkbox"]').each(function () {
                this.checked=true;
             });
            }else{
                $('input[type="checkbox"]').each(function () {
                    this.checked=false;
                });
            }

        });
    </script>
@endsection

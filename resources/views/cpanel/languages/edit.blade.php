@extends('cpanel.index')
@section('title'){{trans('lang.update',['var'=>$lang->name])}}@endsection
@section('menu') {!! getBreadcrumbs('language',$lang->id)->edit !!}  @endsection

@section('css')
    <style>
        label
        {
            display: inline-block;
        }
        .iradio_square-blue
        {
            margin-left: 4px;
        }

    </style>
@endsection
@section('content')
    {!! bsForm::open(['route'=>['languages.update',$lang->id],'method'=>'put']) !!}
    {!! bsForm::text('name',$lang->name) !!}
    {!! bsForm::text('lang_code',$lang->code) !!}
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
        {{trans('lang.flag')}}
    </button>
    <br />
    <br />
    {!! bsForm::radio('direction',[
               'rtl'=>trans('lang.direction_rtl'),
               'ltr'=>trans('lang.direction_ltr'),
               ],$lang->direction) !!}

    {!! bsForm::checkbox('default',1,$lang->default) !!}

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{trans('lang.flag')}}</h4>
                </div>
                <div class="modal-body">
                        @for($i=2; $i < count(scandir(FLAGS_PATH));$i++)
                            <label  for="lang-{{$i}}" id="flag" class="btn
                                {{$lang->flag==scandir(FLAGS_PATH)[$i] ? 'btn-primary':'btn-default'}} flag">
                                <img src="{{FLAGS_URL.scandir(FLAGS_PATH)[$i]}}">
                            </label>
                            <input type="radio" value="{{scandir(FLAGS_PATH)[$i]}}" name="flag" class="iCheck" id="lang-{{$i}}"
                                    {{$lang->flag==scandir(FLAGS_PATH)[$i] ? 'checked=checked':' '}}>
                        @endfor

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{trans('lang.continue')}}</button>
                </div>
            </div>
        </div>
    </div>

    {!! bsForm::close(['submit'=>true,'reset'=>true]) !!}

@endsection
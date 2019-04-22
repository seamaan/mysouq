@extends('cpanel.index')
@section('title')
{{trans('lang.language_create')}}
@endsection
@section('menu') {!! getBreadcrumbs('language')->create !!} @endsection

@section('content')
    {!! bsForm::open(['route'=>'languages.store']) !!}
    {!! bsForm::text('name') !!}
    {!! bsForm::text('lang_code') !!}
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
        {{trans('lang.flag')}}
    </button>
    {!! bsForm::radio('direction',[
                  'rtl'=>trans('lang.direction_rtl'),
                  'ltr'=>trans('lang.direction_ltr'),
                  ]) !!}
    {!! bsForm::checkbox('default',1) !!}

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
                            <label  for="lang-{{$i}}" id="flag" class="btn btn-default flag">
                                <img src="{{FLAGS_URL.scandir(FLAGS_PATH)[$i]}}">
                            </label>
                            <input  value="{{scandir(FLAGS_PATH)[$i]}}" name="flag" class="hidden flag-input" name="flag" type="radio" id="lang-{{$i}}" >
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
@section('js')
    <script>
          $(document).on('click','label.flag',function (e) {
              $('label.flag').addClass('btn-default').removeClass('btn-primary');
            $(this).removeClass('btn-default').addClass('btn-primary');
        })
    </script>
@endsection
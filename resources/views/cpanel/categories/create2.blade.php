@extends('cpanel.index')
@section('title'){{trans('lang.add',['var'=>trans('lang.category')])}}@endsection
@section('menu') {!! getBreadcrumbs('category')->create !!} @endsection
@section('css')
    <style>
        .input-icon.right>i {
            right: auto;
            left: 8px;
            float: left;
        }
    </style>
@endsection
@section('content')
    {!! bsForm::open(['route'=>'categories.store','title'=>trans('lang.add',['var'=>trans('lang.category')]),'files'=>true]) !!}
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">{{trans('lang.general')}}</a></li>
        <li><a data-toggle="tab" href="#other">{{trans('lang.info')}}</a></li>

    </ul>
    <div class="tab-content">
        <br>
        <div id="home" class="tab-pane fade in active">
            {!! bsForm::translate(function($form){
                    $form->text('name');


                }) !!}
            @if(count ($deps)>0 )
                <div class="form-group{{ $errors->has('parent') ? ' has-error' : '' }}">
                    <label for="{{ 'parent' }}" class="control-label">{{ trans('lang.'.trim('main_category','[]')) }}</label>
                    <div class="input-icon right">
                        @if($errors->has('parent'))
                            <i class="fa fa-warning tooltips" data-original-title="{{ $errors->first('parent') }}"></i>
                        @endif
                        <select name="parent" class="form-control checkparent">
                            <option value="">{{trans('lang.none')}}</option>
                            @foreach($deps as $dep)
                                <option  value="{{$dep->id}}">{{$dep->name}}</option>
                            @endforeach

                        </select>

                    </div>
                </div>
            @endif
            <div class="result">
            </div>
            <div class="otherresult">
            </div>
            <p><i class="fa fa-spinner fa-spin fa-2x hidden spin_dep"></i> </p>
        </div>
        <div id="other" class="tab-pane fade">
            {!! bsForm::translate(function($form){
                          $form->textarea('content','',[
                          'class'=>'form-control editor',
                          'id'=>'ckview',
                          ]);

                      }) !!}
            {!! bsForm::image('images[]') !!}
        </div>
    </div>
    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}





@endsection
@section('js')
    <script>
        $(document).on('change','.checkparent',function () {
            var parent=$('option:selected',this).val();
            var master=$('option:selected',this).attr('master');
            //alert(parent);
            var url=$('html').attr('cp-url')+'/categories/checkparent';
            var token=$('#token').val();
            var dep='';
            if(parent == '' || parent==null || master=='master'  ) {
                $('.result').empty();
                $('.otherresult').empty();
            }else {
                //console.log(parent);
                $.ajax({
                    url:url,
                    type:'post',
                    dataType:'json',
                    data:{parent:parent,'_token':token},
                    beforeSend:function () {
                        $('.spin_dep').removeClass('hidden')
                    },success:function (data) {
                        if(data !='false' && master!='parentmaster')
                        {
                            $('.result').empty();
                            $('.otherresult').empty();
                            $('.result').prepend(data);
                        }
                        else if(data !='false' && master=='parentmaster'){
                            $('.otherresult').prepend(data);
                        }
                        $('.spin_dep').addClass('hidden');

                    },error:function () {
                        $('.spin_dep').addClass('hidden');
                    }
                });/***/
            }
        });

    </script>
@endsection

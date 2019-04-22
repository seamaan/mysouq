
        <?php
        $img=App\currency::find($currency->id)->image();
        ?>
        @extends('cpanel.index')
@section('title')
    {{trans('lang.update',['var'=>$currency->name])}}
@stop
@section('menu') {!! getBreadcrumbs('currency',$currency->id)->edit !!}  @endsection

@section('content')

    {!! bsForm::open(['title'=>trans('lang.update',['var'=>$currency->name]),'route'=>['currencies.update',$currency->id],'method'=>'put','files'=>true]) !!}
    {!! bsForm::translate(function($form,$lang) use($currency){
            $form->text('name',$currency->trans('name',$lang));
            })
    !!}
    {!! bsForm::text('currency_code',$currency->currency_code) !!}
    {!! bsForm::text('currency_icon',$currency->currency_icon) !!}

    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}

@endsection
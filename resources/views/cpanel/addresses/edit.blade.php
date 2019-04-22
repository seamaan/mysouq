
        <?php
        $img=App\address::find($address->id)->image();
        ?>
        @extends('cpanel.index')
@section('title')
    {{trans('lang.update',['var'=>$address->name])}}
@stop
@section('menu') {!! getBreadcrumbs('address',$address->id)->edit !!}  @endsection

@section('content')

    {!! bsForm::open(['title'=>trans('lang.update',['var'=>$address->name]),'route'=>['addresses.update',$address->id],'method'=>'put','files'=>true]) !!}
    {!! bsForm::translate(function($form,$lang) use($address){
            $form->text('name',$address->trans('name',$lang));
            })
    !!}
    {!! bsForm::image('addresses',$address->id) !!}

    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}

@endsection
@extends('cpanel.index')
        @section('title'){{trans('lang.add',['var'=>trans('lang.address')])}}@endsection
        @section('menu') {!! getBreadcrumbs('address')->create !!} @endsection
        
        @section('content')
        
            {!! bsForm::open(['title'=>trans('lang.add',['var'=>trans('lang.address')]),'route'=>'addresses.store','files'=>true]) !!}
              {!! bsForm::translate(function($form){
                 $form->text('name');
                 })
             !!}
            {!! bsForm::image('address') !!}
            {!! bsForm::close(['submit'=>true,'reset'=>true])!!}
        @endsection

        
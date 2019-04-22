@extends('cpanel.index')
        @section('title'){{trans('lang.add',['var'=>trans('lang.currency')])}}@endsection
        @section('menu') {!! getBreadcrumbs('currency')->create !!} @endsection
        
        @section('content')
        
            {!! bsForm::open(['title'=>trans('lang.add',['var'=>trans('lang.currency')]),'route'=>'currencies.store','files'=>true]) !!}
              {!! bsForm::translate(function($form){
                 $form->text('name');
                 })
             !!}
            {!! bsForm::text('currency_code') !!}
            {!! bsForm::text('currency_icon') !!}
            {!! bsForm::close(['submit'=>true,'reset'=>true])!!}
        @endsection

        
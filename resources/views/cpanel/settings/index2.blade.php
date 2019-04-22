@extends('cpanel.index')
@section('title') {{ trans('lang.general_settings') }}  @endsection
@section('menu') {!! getBreadcrumbs('setting')->index !!} @endsection

@section('css')
<style>
   .close{
        float: left;
    }
</style>
@endsection
@section('content')


    {!! bsForm::open(['title'=>trans('lang.general_settings')])!!}

    {!! bsForm::text('site_name',site()->trans('site_name')) !!}
    {!! bsForm::text('site_mail',site()->site_mail) !!}
   {{--  {!! bsForm::radio('maintenance',[
            'open'=>trans('lang.maintenance_open'),
            'close'=>trans('lang.maintenance_close'),
            ],site('maintenance')) !!} --}}
    {!! bsForm::text('facebook',site('facebook')) !!}
    {!! bsForm::text('twitter',site('twitter')) !!}
    {!! bsForm::textarea('site_desc',site('site_desc')) !!}
    {!! bsForm::textarea('keywords',site('keywords')) !!}
{{--     <input type="file" class="" name="images[]" multiple>
 --}}
    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}

@endsection
@extends('cpanel.home')
@section('title') {{ trans('lang.currencies') }}  @endsection
@section('menu') {!! getBreadcrumbs('currency',$currency->id)->show !!}  @endsection
@section('content')

<div class="note note-info">
    <p>{!! $currency->trans('info') !!}</p>
</div>
 
@endsection
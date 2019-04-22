@extends('cpanel.home')
@section('title') {{ trans('lang.deliveries') }}  @endsection
@section('menu') {!! getBreadcrumbs('delivery',$delivery->id)->show !!}  @endsection
@section('content')

<div class="note note-info">
    <p>{!! $delivery->trans('info') !!}</p>
</div>
 
@endsection
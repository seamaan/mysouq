@extends('cpanel.home')
@section('title') {{ trans('lang.addresses') }}  @endsection
@section('menu') {!! getBreadcrumbs('address',$address->id)->show !!}  @endsection
@section('content')

<div class="note note-info">
    <p>{!! $address->trans('info') !!}</p>
</div>
 
@endsection
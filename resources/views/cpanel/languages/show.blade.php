@extends('cpanel.index')
@section('title')
    {{$user->name}}
@endsection
@section('content')
    {{$user->email}}
@endsection
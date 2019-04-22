@extends('cpanel.home')
@section('title'){{trans('lang.add',['var'=>trans('lang.role')])}}@endsection
@section('menu') {!! getBreadcrumbs('role')->create !!} @endsection

@section('content')

    {!! bsForm::open(['title'=>trans('lang.add',['var'=>trans('lang.role')]),'route'=>'roles.store','files'=>true]) !!}
    {!! bsForm::text('name') !!}
    {!! bsForm::text('description') !!}
        <div class="panel panel-default">
            <div class="panel-heading">{{trans('lang.permissions')}}</div>
            <div class="panel-body">
                @foreach($permissions as $permission)
                    <div class="checkbox">
                        <label><input type="checkbox" name="permission[]" class="iCheck" value="{{$permission->id}}"></label>
                        <label for="role">{{$permission->name}}</label>

                    </div>

                @endforeach
            </div>
        </div>
    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}
@endsection


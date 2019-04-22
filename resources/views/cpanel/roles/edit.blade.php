@extends('cpanel.home')
@section('title')
    {{trans('lang.update',['var'=>$role->name])}}
@stop
@section('menu') {!! getBreadcrumbs('role',$role->id)->edit !!}  @endsection

@section('content')

    {!! bsForm::open(['title'=>trans('lang.update',['var'=>$role->name]),'route'=>['roles.update',$role->id],'method'=>'put','files'=>true]) !!}
    {!! bsForm::text('name',$role->name) !!}
    {!! bsForm::text('description',$role->description) !!}

    <div class="panel panel-default">
            <div class="panel-heading">{{trans('lang.permissions')}}</div>
            <div class="panel-body">
                @foreach($permissions as $permission)
                    <div class="checkbox">
                        <label><input type="checkbox" name="permission[]" class="iCheck" value="{{$permission->id}}"
                                      @foreach($role->permissions as $role_permit)
                                      @if($role_permit->id==$permission->id)
                                      checked
                                    @endif
                                    @endforeach
                            ></label>
                        <label for="role">{{$permission->name}}</label>

                    </div>

                @endforeach
            </div>
        </div>
    {!! bsForm::close(['submit'=>true,'reset'=>true])!!}

@endsection
@extends('cpanel.index')
@section('title') {{ trans('lang.roles') }}  @endsection
@section('menu') {!! getBreadcrumbs('role')->index !!} @endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-header">
                <h3 class="box-title">{{trans('lang.manage',['var'=>trans('lang.roles')])}}</h3>

                <div class="pull-right">
                    {!! Btn::create() !!}
                    {!! Btn::deleteAll('roles') !!}
                </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="datatable" class="table table-striped table-bordered table-hover datatable">
                <thead>
                <tr>
                    <th><input class="iCheck" id="checkall" type="checkbox" name="checkall"></th>
                    <th>{{trans('lang.name')}}</th>
                    <th>{{trans('lang.description')}}</th>
                    <th class="date">{{trans('lang.date')}}</th>
                    <th class="option">{{trans('lang.options')}}</th>
                </tr>
                </thead>
                <tbody>
              @foreach($roles as $role)
                <tr>
                    <td><input form="delete_form" class="checkbox iCheck" type="checkbox" name="delete[]" value="{{$role->id}}"></td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->description}}</td>
                    <td class="date">{{date('Y/m/d',strtotime($role->created_at))}}</td>
                    <td class="option">
                        {!! Btn::edit($role->id) !!}
                        {!! Btn::delete($role->id,$role->name) !!}

                    </td>
                </tr>
               @endforeach
                </tbody>
                <tfoot>
                <tr>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

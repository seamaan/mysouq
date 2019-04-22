
@extends('cpanel.index')
@section('title') {{ trans('lang.deliveries') }}  @endsection
@section('menu') {!! getBreadcrumbs('delivery')->index !!} @endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-header">
                <h3 class="box-title">{{trans('lang.manage',['var'=>trans('lang.deliveries')])}}</h3>

                <div class="pull-right">
                    {!! Btn::create() !!}
                    {!! Btn::deleteAll('deliveries') !!}
                </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
             <table id="mytable"  class="row-border stripe  table-border hover" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="checkall" class="css-checkbox" name="checkall">
                            <label for="checkall" name="checkbox2_lbl" class="css-label lite-red-check"></label>
                        </th>
                        <th>{{trans('lang.name')}}</th>
                        <th>{{trans('lang.mobile')}}</th>
                        <th>{{trans('lang.email')}}</th>
                        <th>{{trans('lang.address')}}</th>
                        <th>{{trans('lang.control')}}</th>
                    </tr>
                    </thead>
                </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection
 @section('js')
  <script>
                    $(document).ready(function() {
                        var table =$('#mytable').DataTable( {
                            processing: true,
                            serverSide: true,
                            pageLength:50,
                             "ajax":"{{url('cpanel/delivery/getdata')}}",
                            columns: [
                                {data: 'checkbox',
                                    name: '',
                                    searchable:false,
                                    orderable:false,
                                    exportable:false,
                                    printable:false,

                                },
                                {data: 'name', name: 'name'},
                                {data: 'mobile', name: 'mobile'},
                                {data: 'email', name: 'email'},
                                {data: 'address', name: 'address'},
                                {data: 'control', name: '',
                                    searchable:false,
                                    orderable:false,
                                    exportable:false,
                                    printable:false,

                                }
                            ],
                            "language": {
                                "url": '{{url("/public/cpanel/cus/Arabic.json")}}'
                            },

                            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend:'excelHtml5',
                                    'text':' <i class="fa fa-file-excel-o"></i> {{trans('lang.excel')}}',
                                    className: 'green',
                                    exportOptions: {
                                        columns: [  1, 2,3 ]
                                    }

                                },
                                {
                                    extend:'copyHtml5',
                                    'exportOptions': {'columns': ':visible'},
                                    'text':' <i class="fa fa-copy"></i> {{trans('lang.copy')}}',
                                    className: 'orang',
                                    exportOptions: {
                                        columns: [  1, 2,3 ]
                                    }


                                },
                                {
                                    'extend': 'pageLength',
                                    'fade':false,
                                },




                            ]
                        } );

                    });
                </script>
 @endsection

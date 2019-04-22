@extends('cpanel.index')
@section('title') {{ trans('lang.categories') }}  @endsection
@section('menu') {!! getBreadcrumbs('category')->index !!} @endsection

@section('css')
    <style>
        .dange{
            background-color: red !important;
        }

    </style>
@endsection
@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-header">
                <h3 class="box-title">{{trans('lang.manage',['var'=>trans('lang.categories')])}}</h3>

                <div class="pull-right">
                    {!! Btn::create() !!}
                    {!! Btn::deleteAll('categories') !!}
                </div>
            </div>

            <!-- /.box-header -->

            <div class="box-body">

                <table id="mytable"  class="row-border row-details stripe  table-border hover" width="100%" cellspacing="2">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="checkall" class="css-checkbox" name="checkall">
                            <label for="checkall" name="checkbox2_lbl" class="css-label lite-red-check"></label>
                        </th>
                        <th>{{trans('lang.name')}}</th>
                        <th>{{trans('lang.rec_num')}}</th>
                        <th>{{trans('lang.created_at')}}</th>
                        <th>{{trans('lang.control')}}</th>
                    </tr>
                    </thead>
                </table>

                <!-- /.box-body -->
            </div>



            @endsection
            @section('js')
                <script>
                    $(document).ready(function() {
                        var table =$('#mytable').DataTable( {
                            processing: true,
                            serverSide: true,
                            pageLength:20,
                            "ajax":"{{url('cpanel/category/getdata')}}",
                            columns: [
                                {data: 'checkbox',
                                    name: '',
                                    searchable:false,
                                    orderable:false,
                                    exportable:false,
                                    printable:false,

                                },
                                {data: 'name', name: 'name'},
                                {data: 'rec_num',
                                    name: '',
                                    searchable:false,
                                    orderable:false,
                                },
                                {data: 'created_at', name: 'created_at'},
                                {data: 'control',
                                    name: '',
                                    searchable:false,
                                    orderable:false,
                                    exportable:false,
                                    printable:false,

                                }
                            ],
                            "language": {
                                "url": '{{url("/public/cpanel/cus/Arabic.json")}}'
                            },

                            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
                                    {{--{--}}
                                    {{--extend:'pdfHtml5',--}}
                                    {{--'text':' <i class="fa fa-file-pdf-o"></i> {{trans('lang.pdf')}}',--}}
                                    {{--className: 'redpdf',--}}
                                    {{--exportOptions: {--}}
                                    {{--columns: [  1, 2,3 ]--}}
                                    {{--}--}}

                                    {{--},--}}
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

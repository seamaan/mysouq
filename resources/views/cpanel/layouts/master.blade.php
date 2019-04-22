@include('cpanel.layouts.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('cpanel.layouts.header')
    <!-- Left side column. contains the logo and sidebar -->
@include('cpanel.layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Advanced Form Elements
                <small>Preview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">Advanced Elements</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@include('cpanel.layouts.footer')
@include('cpanel.layouts.control-sidebar')

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@include('cpanel.layouts.js')
@stack('jas')
@yield('js')
</body>
</html>

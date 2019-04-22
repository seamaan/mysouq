<?php
//        $id=5;
//dd(App\User::find($id));
if (App\Admin::count()==0){
    \App\Admin::create([
        'username'=>'seamaan',
        'name'=>'mohammed hamada',
        'email'=>'hamadasoft.com@gmail.com',
        'active'=>1,
        'password'=>bcrypt('1234'),
    ]);
}



?>
<!-- the fixed layout is not compatible with sidebar-mini -->
@include('cpanel.layouts.head')
<style>
    body{
        background-color: #d2d6de;
    }
    .login-box-body{padding: 30px;
    }
</style>
</head>
<body>
<!-- Site wrapper -->
<div class="wrapper">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{url('cpanel/')}}"><b>{{trans('lang.login')}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">

            <form class="form-horizontal" role="form" method="POST" action="{{ url(cp.'login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif

                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                    <input id="password" type="password" class="form-control" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif

                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8" style="text-align: left">
                        <div class="checkbox icheck">
                            <label >
                                <input class="iCheck" type="checkbox"  name="remember"> {{trans('lang.rememberme')}}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{trans('lang.login')}}</button>


                    </div>

                    <!-- /.col -->
                </div>
                </form>
            <!-- /.social-auth-links -->
        </div>
    </div>
    <div class="row">
        <div class="container text-center">
            CopyRight 2017
        </div>
    </div>
    @include('cpanel.layouts.js')

</div>
</body>
</html>





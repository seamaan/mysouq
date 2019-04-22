<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{$cpanel}}img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{admin()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="{{url(cp)}}"><i class="fa fa-home"></i> {{trans('lang.home')}}</a>
            </li>

            {{--            @if(admin()->role =='admin' || in_array('settings', $pname)  )--}}
            @if(admin()->job =='admin' || in_array('settings', $rname)  )
                {{--@can('settings') )--}}
                <li class="treeview
                {{menu_active('settings')||
                  menu_active('addresses')||
                  menu_active('languages')||
                  menu_active('weights')||
                  menu_active('lengths')||
                  menu_active('measurementunits')||
                  menu_active('currencies')
                  ?'active':''}}
                        ">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>{{trans('lang.main_settings')}} </span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{menu_active('settings')}}"><a href="{{url(cp.'settings')}}"><i class="fa fa-cogs"></i>{{trans('lang.general_settings')}}</a></li>
                        <li class="{{menu_active('addresses')}}"><a href="{{url(cp.'addresses')}}"><i class="fa fa-home"></i>{{trans('lang.Addresses')}}</a></li>
                        <li class="{{menu_active('languages')}}"><a href="{{url(cp.'languages')}}"><i class="fa fa-language"></i>{{trans('lang.languages')}}</a></li>
                        <li class="{{menu_active('currencies')}}"><a href="{{url(cp.'currencies')}}"><i class="fa fa-money"></i>{{trans('lang.currencies')}}</a></li>
                        <li class="{{menu_active('weights')}}"><a href="{{url(cp.'weights')}}"><i class="fa fa-cubes"></i>{{trans('lang.weights')}}</a></li>
                        <li class="{{menu_active('lengths')}}"><a href="{{url(cp.'lengths')}}"><i class="fa fa-exchange"></i>{{trans('lang.lengths')}}</a></li>
                        <li class="{{menu_active('measurementunits')}}"><a href="{{url(cp.'measurementunits')}}"><i class="fa fa-exchange"></i>{{trans('lang.measurementunits')}}</a></li>
                    </ul>
                </li>
                {{--@endcan--}}
                @endif
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{$cpanel}}index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="{{$cpanel}}index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

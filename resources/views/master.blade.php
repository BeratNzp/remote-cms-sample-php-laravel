@section('page_title', 'Anasayfa')
@include('layouts.head')
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="#" class="site_title">
                        <i class="fa fa-server"></i>
                        <span>{{ config('app.name') }}</span>
                    </a>
                </div>
                <div class="clearfix"></div>
                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="{{ asset("images/img.jpg") }}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Hoşgeldiniz,</span>
                        <h2>{{ auth()->user()->name_surname() }}</h2>
                        <small>{{ auth()->user()->department() }}</small>
                    </div>
                </div>
                <!-- /menu profile quick info -->
                <br/>
                <!-- sidebar menu -->
                @include('layouts.sidebar')
                <!-- .sidebar menu -->
                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Site ayarları">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Siteyi görüntüle">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Siteye erişimi kilitle">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Çıkış Yap" href="{{ route('user.logout_action') }}">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>
        <!-- top navigation -->
        @include('layouts.navbar')
        <!-- .top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
        @yield('page_content')
        </div>
        <!-- .page content -->

        <!-- footer content -->
        @include('layouts.footer')
        <!-- .footer content -->
    </div>
</div>
@include('layouts.scripts')
</body>
</html>

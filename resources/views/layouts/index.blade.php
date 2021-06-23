<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        {{-- @section('page_title')
        {{ env('APP_NAME') }}
        @show --}}
        نوبت دهی باشگاه imotion
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/dist/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="/dist/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="/dist/css/custom.css">
    <!-- PersianCalender -->
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Font awesome -->
    <link href="/plugins/persiancalender/jquery.md.bootstrap.datetimepicker.style.css" rel="stylesheet"/>
    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            {{-- <!-- Right navbar links -->
            <ul class="navbar-nav mr-auto-navbav">
                <!-- Messages Dropdown Menu -->


            </ul> --}}
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                {{-- <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" --}}
                    {{-- style="opacity: .8"> --}}
                <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        {{-- <img src="/uploads/{{ Auth::user()->image_path }}" class="img-circle elevation-2" alt="User Image"> --}}
                        <img src="/dist/img/prof.jpeg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="/login" class="d-block">
                            {{ Auth::user()->name }}

                            <i class="fa fa-window-close"></i>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            @if(Request::route()->getName() == 'athletedashboard' || Request::route()->getName() =="admin_dashboard" )
                                <a href="/" class="nav-link active">
                                   @else
                                <a href="{{ $role == 'athlete' ? route('athletedashboard') : route('admin_dashboard') }}" class="nav-link">
                                    @endif
                                    <!-- <i class="far fa-circle nav-icon"></i> -->
                                    <p>داشبورد</p>
                                </a>
                            {{-- @endif     --}}
                        </li>
                        @if($role == 'athlete')
                        <li class="nav-item">
                            @if(Request::route()->getName() == 'athleterule')
                            <a href="/athlete/rules" class="nav-link active">
                                @else
                            <a href="{{ route('athleterule') }}" class="nav-link">
                                @endif
                                <p>قوانین</p>
                            </a>
                        </li>
                        @endif
                        {{-- @if (Gate::allows('parameters')) --}}
                        <!-- <li class="nav-header">تعاریف پایه</li> -->
                        @if(strpos(\Request::route()->getName(), 'athlete')===0 || strpos(\Request::route()->getName(),
                        'admin')===0)
                        <li class="nav-item has-treeview menu-open">
                            @else
                        <li class="nav-item has-treeview">
                            @endif
                            {{-- <a href="#" class="nav-link">
                                <!-- <i class="nav-icon fas fa-bookmark"></i> -->
                                <p>
                                    تنظیمات
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <p>تغییر رمز عبور</p>
                                    </a>
                                </li>
                                <li class="nav-item">

                                </li>

                            </ul> --}}
                        </li>
                        {{-- @if($role == 'athlete')
                        <li class="nav-item">
                            @if(strpos(\Request::route()->getName(), 'message')===0)
                            <a href="#" class="nav-link active">
                                @else
                                <a href="{{ route('athletetaketurn') }}" class="nav-link">
                                    @endif
                                    <p>نوبت گیری</p>
                                </a>
                        </li>
                        @endif --}}

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
            @if (isset($msg_success))
            <div class="card card-success" id="success">
                <div class="card-header">
                    <h3 class="card-title">موفقیت</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{ $msg_success }}
                </div>
                <!-- /.card-body -->
            </div>
            @endif
            @if (isset($msg_error))
            <div class="card card-danger" id="error">
                <div class="card-header">
                    <h3 class="card-title">خطا</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i>
                        </button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{ $msg_error }}
                    {{-- abcd{{ $errors }} --}}
                    @if ($errors->any())
                       <div>
                          <ul>
                             @foreach ($errors->all() as $error)
                               <li>{{ $error }}</li>
                             @endforeach
                         </ul>
                      </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
            @endif
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <!--
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.0-rc.1
    </div>
    -->
            کلیه حقوق متعلق به
            <strong>
                <a href="http://i-motion.ir/">
                    imotion
                </a>
                &copy;
            </strong>
            است
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->




    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 rtl -->
    <script src="/dist/js/bootstrap.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.js"></script>
    <!-- PersianCalender -->
    <script src="/plugins/persiancalender/jquery.md.bootstrap.datetimepicker.js"></script>

    @yield('js')

    <script>
        $(document).ready(function(){
            $("input.pdate").each(function(id, field){
                $(field).MdPersianDateTimePicker({
                    targetTextSelector: '#' + field.id
                });
            });
        });
    </script>

</body>

</html>

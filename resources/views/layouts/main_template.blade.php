<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title> BeautyClick Custom Portal </title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('plugins/morrisjs/morris.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('css/themes/all-themes.css') }}" rel="stylesheet" />
</head>

<body class="theme-purple">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#"> BeautyClick Management Portal </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">

            <div class="row">
              <legend></legend>
            </div>

            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header"> Navigation </li>
                    
                    <li class="hidden <?php echo Request::segment(1) == "home" ? "active" : "" ; ?>" >
                        <a href="{{ url('home') }}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    
                    <li class="<?php echo Request::segment(1) == "reward" ? "active" : "" ; ?>" >
                        <a href="#" class="menu-toggle">
                            <i class="material-icons">view_comfy</i>
                            <span> Loyalty & Rewards </span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a class="hidden" href="{{ url('reward/customers') }}">
                                    <i class="material-icons col-light-green">group</i>
                                    <span>Rewards Customers</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reward/activitys') }}">
                                    <i class="material-icons col-light-green">view_headline</i>
                                    <span>Rewards Activities</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('reward/sms') }}">
                                    <i class="material-icons col-light-green">notifications_active</i>
                                    <span>Rewards Sms Outbox</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                                        
                    <li class="hidden <?php echo Request::segment(1) == "order" ? "active" : "" ; ?>" >
                        <a href="{{ url('order') }}">
                            <i class="material-icons">view_headline</i>
                            <span>Orders</span>
                        </a>
                    </li>
                    
                    <li class="hidden <?php echo Request::segment(1) == "delivery" ? "active" : "" ; ?>" >
                        <a href="{{ url('delivery') }}">
                            <i class="material-icons">view_headline</i>
                            <span>Deliveries</span>
                        </a>
                    </li>
                    <li class="hidden <?php echo Request::segment(1) == "product" ? "active" : "" ; ?>" >
                        <a href="{{ url('product') }}">
                            <i class="material-icons">apps</i>
                            <span>Products</span>
                        </a>
                    </li>
                    
                    <li class="hidden <?php echo Request::segment(1) == "combination" ? "active" : "" ; ?>" >
                        <a href="{{ url('combination') }}">
                            <i class="material-icons">format_align_justify</i>
                            <span>Combinations</span>
                        </a>
                    </li>
                    
                    <li class="hidden <?php echo Request::segment(1) == "stock" ? "active" : "" ; ?>" >
                        <a href="{{ url('stock') }}">
                            <i class="material-icons">list</i>
                            <span>Stock</span>
                        </a>
                    </li>
                    
                    <li class="hidden <?php echo Request::segment(1) == "report" ? "active" : "" ; ?>" >
                        <a href="#" class="menu-toggle">
                            <i class="material-icons">vertical_split</i>
                            <span>Reports</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{ url('report') }}">
                                    <i class="material-icons col-light-green">donut_large</i>
                                    <span>Report 1</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('report') }}">
                                    <i class="material-icons col-light-green">donut_large</i>
                                    <span>Report 2</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('report') }}">
                                    <i class="material-icons col-light-green">donut_large</i>
                                    <span>Report 3</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; <?php echo date("Y"); ?> <a href="//beautyclick.co.ke">Africanhair Ltd.</a>
                </div>
                <div class="version">
                    <b> Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->

    </section>

    <section class="content">
      
        <div class="container-fluid">
          
            @yield('content')
          
        </div>
      
    </section>

    <!-- Jquery Core Js -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.js')}}"></script>

    <!-- Select Plugin Js -->
    <script src="{{asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{asset('plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{asset('plugins/node-waves/waves.js')}}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{asset('plugins/jquery-countto/jquery.countTo.js')}}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('plugins/morrisjs/morris.js')}}"></script>

    <!-- ChartJs -->
    <script src="{{asset('plugins/chartjs/Chart.bundle.js')}}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{asset('plugins/flot-charts/jquery.flot.js')}}"></script>
    <script src="{{asset('plugins/flot-charts/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('plugins/flot-charts/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('plugins/flot-charts/jquery.flot.categories.js')}}"></script>
    <script src="{{asset('plugins/flot-charts/jquery.flot.time.js')}}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{asset('plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('js/admin.js')}}"></script>
    <script src="{{asset('js/pages/index.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('js/demo.js')}}"></script>
    
</body>

</html>
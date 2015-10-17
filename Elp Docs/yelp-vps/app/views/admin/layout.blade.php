<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="images/favicon.png">

    <title>@yield('title')</title>

    <!--Core CSS -->
    <link href="{{asset('bucketadmin/bs3/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('bucketadmin/css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{asset('bucketadmin/assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{asset('bucketadmin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('bucketadmin/css/style-responsive.css')}}" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="{{asset('bucketadmin/js/ie8/ie8-responsive-file-warning.js')}}"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    @yield('head')
</head>

<body>

<section id="container" >
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="{{URL::route('adminDashboard')}}" class="logo">
        <img src="{{ asset(Image::path('/bucketadmin/images/logo.png', 'resizeCrop', 160, 70)) }}" alt="">
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->



<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <?php $image = ($user->picture)?$user->picture:Config::get('database.default_profile_pic'); ?>
                <img alt="" src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
                <span class="username">Hi {{$user->username}}</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="{{URL::route('logout')}}"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
   
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->            <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a href="{{URL::route('adminDashboard')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{URL::route('adminPagesManagement')}}">
                    <i class="fa fa-file-text"></i>
                    <span>Pages Management</span>
                </a>
            </li>
            <li>
                <a href="{{URL::route('adminUserManagement')}}">
                    <i class="fa fa-users"></i>
                    <span>User Management</span>
                </a>
            </li>
            <li>
                <a href="{{URL::route('adminCategoryManagement')}}">
                    <i class="fa fa-list"></i>
                    <span>Category Management</span>
                </a>
            </li>
            <li>
                <a href="{{URL::route('adminQuestionManagement')}}">
                    <i class="fa fa-question-circle"></i>
                    <span>Question Management</span>
                </a>
            </li>

            <li>
                <a href="{{URL::route('adminSettings')}}">
                    <i class="fa fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-cog"></i>
                    <span>Businesses</span>
                </a>
                <ul class="sub">
                    <li><a href="{{URL::route('businessManagement')}}">Business Management</a></li>
                    <li><a href="{{URL::route('adminEditManagement')}}">Reported Edit</a></li>
                    <li><a href="{{URL::route('adminBusinessClaimRequests')}}">Business Claims</a></li>
                </ul>
            </li>
            <li>
                <a href="{{URL::route('adminReviewManagement')}}">
                    <i class="fa fa-star"></i>
                    <span>Review Management</span>
                </a>
            </li>
            <li>
                <a href="{{URL::route('adminAdsManagement')}}">
                    <i class="fa fa-bullhorn"></i>
                    <span>Advertisement Management</span>
                </a>
            </li>
           
        </ul></div>        
<!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->

        @if(Session::has('success'))
  <div class="alert alert-success alert-dismissable"> {{Session::get('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  </div>
  
  @endif
  @if(Session::has('error'))
    <div class="alert alert-danger alert-dismissable"> {{Session::get('error')}} 
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
    
  @endif
  @if(Session::has('errors'))
  <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
  @foreach(Session::get('errors')->getMessages() as $error)
      <li> {{$error[0]}} </li>
  @endforeach
    </ul>
  </div>
@endif

        @yield('content')
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->


</section>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="{{asset('bucketadmin/js/lib/jquery.js')}}"></script>
<script src="{{asset('bucketadmin/bs3/js/bootstrap.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{asset('bucketadmin/js/accordion-menu/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('bucketadmin/js/scrollTo/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('bucketadmin/assets/jQuery-slimScroll-1.3.0/jquery.slimscroll.js')}}"></script>
<script src="{{asset('bucketadmin/js/nicescroll/jquery.nicescroll.js')}}"></script>
<!--Easy Pie Chart-->
<script src="{{asset('bucketadmin/assets/easypiechart/jquery.easypiechart.js')}}"></script>
<!--Sparkline Chart-->
<script src="{{asset('bucketadmin/assets/sparkline/jquery.sparkline.js')}}"></script>


<!--common script init for all pages-->
<script src="{{asset('bucketadmin/js/scripts.js')}}"></script>

@yield('script')

</body>
</html>

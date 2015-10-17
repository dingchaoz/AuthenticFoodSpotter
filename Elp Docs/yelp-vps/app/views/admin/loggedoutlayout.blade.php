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
</head>

<body>

<section id="container" >

@yield('content')

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
<!--jQuery Flot Chart-->
<script src="{{asset('bucketadmin/assets/flot-chart/jquery.flot.js')}}"></script>
<script src="{{asset('bucketadmin/assets/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{asset('bucketadmin/assets/flot-chart/jquery.flot.resize.js')}}"></script>
<script src="{{asset('bucketadmin/assets/flot-chart/jquery.flot.pie.resize.js')}}"></script>


<!--common script init for all pages-->
<script src="{{asset('bucketadmin/js/scripts.js')}}"></script>

</body>
</html>

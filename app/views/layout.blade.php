<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{Config::get('settings.keywords')}}">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive-style.css')}}" rel="stylesheet">

    @yield('head')
  </head>
  <body>

  <!-- Navbar Starts -->
  <div class="row nav-color navbar-inverse">
    <div class="col-md-2 col-md-offset-1 col-sm-12 col-xs-10 logo">
    <center>
      <a href="{{URL::route('dashboard')}}">
        <img src="{{ asset(Image::path('/img/header_logo.png', 'resizeCrop', 160, 70)) }}" style="padding-top: 5px;">
      </a>
    </center>
    </div>
    <div class="col-md-9 col-sm-12 col-xs-12">
      <div class="row custom-nav">
        <form method="get" action="{{URL::to('search')}}">
          <div class="col-md-4 col-sm-3 col-xs-4">
            <input type="text" class="form-control search-nav" placeholder="FIND" style="width::100%;" name="find" value="{{(isset($_GET['find']))?$_GET['find']:''}}">
          </div>
          <div class="col-md-4 col-sm-3 col-xs-4">
            <input type="text" class="form-control search-nav" placeholder="NEAR" style="width:100%;" name="near" value="{{(isset($_GET['near']))?$_GET['near']:''}}">
          </div>
          <div class="col-md-1 col-sm-1 col-xs-1">
            <button type="submit" class="btn searchicon"><i class="icon-search"></i></button>
          </div>
        </form>
          @if(Sentry::check())
          <?php $loggedin_user = Sentry::getUser(); ?>
          <div class="col-md-2 col-sm-2 col-xs-2 login-1">
            <?php $image = ($loggedin_user->picture)?$loggedin_user->picture:Config::get('database.default_profile_pic'); ?>
            <img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}" class="header-user-photo">
          
            <div class="dropdown">
              <button class="btn btn-primary searchicon dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu1">
                <li><a href="{{URL::route('accountSettings')}}">Account settings</a></li>
                <li><a href="{{URL::route('logout')}}">Log out</a></li>
              </ul>
            </div>
          </div>
          @else
          <div class="col-md-2 col-sm-2 col-xs-2 login">
            <a href="{{URL::route('login')}}" class="btn btn-primary">Login / Register </a>
          </div>
          @endif
      </div>
      <div class="row">
          <ul class="small-nav">
            <li><a href="{{URL::route('dashboard')}}">Home</a></li>
            <li><a href="{{URL::route('explore')}}">Explore</a></li>
            <li><a href="{{URL::route('viewProfile')}}">About Me</a></li>
            <li><a href="{{URL::route('findFriends')}}">Find Friends</a></li>
            <li><a href="{{URL::route('viewMessages')}}">Messages</a></li>
          </ul>
      </div>
    </div>
  </div> 

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

  <!-- Navbar Ends -->
  
  @yield('content')

  <div class="bottom-page">
    <center>
      <p>
      <?php 

      $pages = Static_page::all();

      foreach($pages as $page)
        { 
          echo '<a href="'.URL::route('viewPage',array('id'=>$page->id)).'">'.$page->label.'</a> ';
        }

      ?>

      </p>
      <div class="footer-text">
        <p>{{Config::get('settings.footer')}}</p>
      </div>
    </center>
  </div>
  <!-- Main Content Ends -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery-1.10.2.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      $('.dropdownicon').click(function(){
        $('.small-nav').toggle('fast');
      });
    });
    </script>

  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '866706236754363',
        xfbml      : true,
        version    : 'v2.5'
      });
    };

    (function(d, s, id){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>

    @yield('script')
</body>
</html>

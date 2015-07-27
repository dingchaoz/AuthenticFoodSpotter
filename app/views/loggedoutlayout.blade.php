<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
  </head>
  <body>

  <!-- Navbar Starts -->
  <nav class="navbar navbar-inverse" role="navigation">
    <a href="{{URL::route('dashboard')}}"><img src="{{ asset(Image::path('/img/header_logo.png', 'resizeCrop', 160, 70)) }}" style="margin-left:45%;"></a>
  </nav>  

  @if(Session::has('success'))
	<div class="alert alert-success alert-dismissable"> {{Session::get('success')}} </div>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	@endif
	@if(Session::has('error'))
		<div class="alert alert-danger alert-dismissable"> {{Session::get('error')}} </div>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
      <img src="{{asset('img/bottom-pic.png')}}" class="housepic visible-lg">
      <div class="footer-text">
      <br>
            <p>
      <?php 

      $pages = Static_page::all();

      foreach($pages as $page)
        { 
          echo '<a href="'.URL::route('viewPage',array('id'=>$page->id)).'">'.$page->label.'</a> ';
        }

      ?>

      </p>

        <p>{{Config::get('settings.footer')}}</p>
      </div>
    </center>
  </div>
</body>
</html>

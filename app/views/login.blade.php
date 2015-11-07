@extends('loggedoutlayout')

@section('title','login')

@section('content')

<div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 login-form">
        <form class="login-form" method="post" action="{{URL::to('login')}}">
          <center> <h3>Log in to {{Config::get('settings.title')}}</h3></center>
          <div class="row form-group">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
              <input type="text" name="email" class="form-control" placeholder="Email" required="required">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
              <input type="password" name="password" class="form-control" placeholder="Password" required="required">
            </div>
          </div>
          <div class="row text-center">
          <h5 style="margin-left:33%;font-size:12px;"><a href="{{URL::route('forgotPassword')}}">Forgot Password?</a></h5>
          </div>
          <div class="row text-center">
            {{--<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">--}}
              <button type="submit" class="btn btn-primary login-button" style="width:100%;">Log In</button>
            </div>
          </div>
          <div class="row text-center">
            <h5 style="margin-left:33%;font-size:12px;">New to us?<a href="{{URL::route('register')}}">Sign Up</a></h5>
          </div>
        </form>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 hidden-xs side-pic">
          <center>
            <img src="{{asset('img/side-pic.png')}}" alt="yelp">
          </center>
        </div>
      </div>
  </div>

@stop
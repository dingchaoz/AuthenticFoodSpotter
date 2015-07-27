@extends('loggedoutlayout')


@section('title','Register')


@section('content')

<div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 login-form">
        <form class="login-form" method="post" action="{{URL::to('register')}}">
          <center> 
            <h3>Sign Up for Best Food</h3>
            <p style="font-weight:bold;">Connect with great local business</p>
          </center>
          <br>
          @if(!isset($result))
          <div class="row form-group">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 facebook-login">
              <a href="{{URL::route('flogin')}}" class="btn facebook" style="width:100%;"><i class="icon-facebook" style="padding:10px;"></i>Sign Up with Facebook</a>
            </div>
          </div>

          <center><p style="font-size:12px;margin-top:-12px;">Don't worry, we never post without your permission.</p></center>
          <br>
          <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
              <hr><span class="or">OR</span>
            </div>
          </div>
          @endif
          <div class="row form-group">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
              <input type="text" class="form-control firstlast" name="first_name" placeholder="First Name" required="required" value="{{(isset($result['first_name']))?$result['first_name']:''}}">
              <input type="text" class="form-control firstlast" name="last_name" placeholder="Last Name" required="required" value="{{(isset($result['last_name']))?$result['last_name']:''}}">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
              <input type="text" class="form-control" placeholder="Email" name="email" required="required" value="{{(isset($result['email']))?$result['email']:''}}">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
              <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
          </div>
          <div class="row text-center">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
              <button type="submit" class="btn btn-primary login-button" style="width:100%;">Register</button>
            </div>
          </div>
          <div class="row text-center">
            <h5 style="margin-left:33%;font-size:12px;">Already on ?<a href="{{URL::route('login')}}">Log In</a></h5>
          </div>
        </form>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 side-pic">
          <center>
            <img src="{{asset('img/side-pic.png')}}" alt="yelp">
          </center>
        </div>
      </div>
  </div>





@stop
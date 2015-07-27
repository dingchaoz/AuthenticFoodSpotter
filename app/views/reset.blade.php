@extends('loggedoutlayout')

@section('title','login')

@section('content')

<div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 login-form">
          <center> <h3>Reset Password</h3></center>
          <form method="post" action="{{URL::to('reset')}}">
          
          <div class="form-group">
            <label>email address</label>
            <input type="email" name="email" class="form-control"  placeholder="email" style="width:100%" value="{{(isset($_GET['email']))?$_GET['email']:''}}" required>
          </div>

          <div class="form-group">
            <label >reset code</label>
            <input type="text" name="code" class="form-control"  placeholder="reset code which you recieved in email" style="width:100%" value="{{(isset($_GET['code']))?$_GET['code']:''}}" required>
          </div>

          <div class="form-group">
            <label> Password </label>
            <input type="password" name="password" class="form-control" style="width: 100%" required>
          </div>

          <div class="form-group">
            <label> Repeat Password </label>
            <input type="password" name="password_confirmation" class="form-control" style="width: 100%" required>
          </div>

          <button type="submit" class="btn btn-primary login-button">Reset Password</button>
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
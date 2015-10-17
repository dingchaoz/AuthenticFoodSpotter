@extends('loggedoutlayout')

@section('title','Forgot Password')

@section('content')

<div class="container">
      <div class="row" style="margin-top:35px;">
        <div class="col-md-12">
         <legend>Forgot Password</legend>
        </div>
      </div>
      <div class="row">
        <form method="post" action="{{URL::to('forgotPassword')}}">
        <div class="col-md-6 col-sm-8 col-xs-12">
          <label>Email Address</label>
          <input type="email" required="required" name="email">
          <button type="submit" class="btn btn-sm btn-primary">Reset Password</button>
          <p><a href="{{URL::route('login')}}">Return to Login?</a></p>
        </div>         
        </form>
      </div>
  </div>

@stop
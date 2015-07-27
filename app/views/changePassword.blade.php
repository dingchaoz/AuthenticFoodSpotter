@extends('layout')

@section('title','Change Password')

@section('content')

<div class="container full-content">
    <div class="row">
      <div class="col-md-12">
        <h6> <a href="#">Account Settings</a> >> Change Password </h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7 account-setting-container">
        <form class="profile-info" method="post" action="{{URL::route('updatePassword')}}">
            <div class="form-group">
              <label><h5>Current Password</h5></label>
              <input type="password" class="form-control" name="current_password" required="required">
            </div>
            <div class="form-group">
              <label><h5>New Password</h5></label>
              <input type="password" class="form-control" name="new_password" required="required">
            </div>
            <div class="form-group">
              
            <div class="form-group">
              <button type="submit" class="btn btn-primary"> Save Changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>


@stop
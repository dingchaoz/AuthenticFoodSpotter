@extends('layout')

@section('title','Change Password')

@section('content')

<div class="container full-content">
    <div class="row">
      <div class="col-md-12">
        <h6> <a href="{{URL::route('accountSettings')}}">Account Settings</a> >> Get Vanity URL </h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7 account-setting-container">
        <form class="profile-info" method="post" action="{{URL::route('updateUsername')}}">
            <div class="form-group">
              <label><h5>Username</h5></label>
              <p>Your Vanity URL will be like http://yelp.com/&lt;username&gt;</p>
              <input type="text" class="form-control" name="username" required="required" value="{{$user->username}}">
            </div>
              
            <div class="form-group">
              <button type="submit" class="btn btn-primary"> Save Changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>


@stop
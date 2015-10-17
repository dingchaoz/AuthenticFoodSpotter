@extends('layout')

@section('content')

<div class="container full-content">
    <div class="row">
      <div class="col-md-12">
        <h6> <a href="{{URL::route('accountSettings')}}">Account Settings</a> >> Overview </h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7 account-setting-container">
        <div class="row account-setting-header">
          <div class="col-md-11">
            <h4 style="color: #c41200;">{{ucfirst($user->first_name)}}'s Account Settings</h4>
          </div>
        </div>
        <div class="row account-setting-option">
          <div class="col-md-12">
            <p><a href="{{URL::route('editProfile')}}">Profile</a></p>
            <p>Edit your name, public profile information, and your Member Search preference.</p>
          </div>
        </div>
        <div class="row account-setting-option">
          <div class="col-md-12">
            <p><a href="{{URL::route('changePassword')}}">Password</a></p>
            <p>Change the password for your account</p>
          </div>
        </div>
        <div class="row account-setting-option">
          <div class="col-md-12">
            <p><a href="{{URL::route('getVanityUrl')}}">Get Vanity Url</a></p>
            <p>Change your vanity URL here</p>
          </div>
        </div>
        
      </div>
    </div>
  </div>

@stop
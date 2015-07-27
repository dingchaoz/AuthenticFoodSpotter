@extends('layout')

@section('title','Edit Profile')

@section('content')

<div class="container full-content">
    <div class="row">
      <div class="col-md-12">
        <h6> <a href="{{URL::route('accountSettings')}}">Account Settings</a> >> Profile </h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7 account-setting-container">
        <div class="row account-setting-header">
          <div class="col-md-12">
            <h4 style="color:#c41200;">Your Public Profile</h4>
            <p>So who are you, then? Tell the rest about your pretty little self.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h4>Your Profile Pic</h4>
            <form method="post" action="{{URL::route('editProfile')}}" enctype="multipart/form-data">
	            <input type="file" class="form-group" name="profile_picture" required="true">
	            <button type="submit" class="btn btn-primary">Upload</button>
            </form>
            <?php $image = ($user->picture)?$user->picture:Config::get('database.default_profile_pic'); ?>
            <img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 200, 200) )}}">
          </div>
        </div>
        <form class="profile-info" method="post" action="{{URL::route('editProfile')}}">
            <div class="form-group">
              <label><h5>First Name</h5></label>
              <p>This is a required field.</p>
              <input type="text" class="form-control" name="first_name" required="required" value="{{$user->first_name}}">
            </div>
            <div class="form-group">
              <label><h5>Last Name</h5></label>
              <p>This field is required.</p>
              <input type="text" class="form-control" name="last_name" required="required" value="{{$user->last_name}}">
            </div>
            @foreach($questions as $question)
              <div class="form-group">
                <label><h5>{{$question->question}}</h5></label>
                <p>{{$question->text}}</p>
                <input type="text" class="form-control" name="question{{$question->id}}" required="required" value="{{(isset($answers[$question->id]))?$answers[$question->id]:''}}">
              </div>
            @endforeach
                
            <div class="form-group">
              <button type="submit" class="btn btn-primary"> Save Changes</button>
              
            </div>
          </form>
      </div>
    </div>
  </div>



@stop
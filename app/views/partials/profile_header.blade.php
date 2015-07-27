<div class="container full-content">
	<div class="row">
		<div class="user-profile-nav">
			<li {{($currentMenu=="home")?"class='active'":''}}><a href="{{URL::route('viewProfile')}}">Profile Home</a></li>
			<li {{($currentMenu=="reviews")?"class='active'":''}}><a href="{{URL::route('viewReviews')}}">Reviews</a></li>
			<li {{($currentMenu=="friends")?"class='active'":''}}><a href="{{URL::route('viewFriends')}}">Friends</a></li>
			<li {{($currentMenu=="followers")?"class='active'":''}}><a href="{{URL::route('viewFollowers')}}">Followers</a></li>
		</div>
	</div>
	<div class="row user-profile-header">
		<div class="col-md-9">
			<h3 style="display:inline-block;">{{$user->first_name}} {{$user->last_name}}'s Profile</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-12">
			<center>
			<div class="row user-profile-list">
				<?php $image = ($user->picture)?$user->picture:Config::get('database.default_profile_pic'); ?>
              <img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 100, 100) )}}">
				<li><i class="icon-group" style="color:blue;"></i><a href="#"> {{count($friends)}} Friends</a></li>
				<li><i class="icon-star" style="color:orange;"></i><a href="#"> {{$user->reviews->count()}} Review</a></li>

				<p><span class="bold">Yelping since</span><br>
				{{date_format($user->created_at,'M Y')}}
				</p>

				<p><a href="{{URL::Route('editProfile')}}">Update your profile</a></p>
			</div>
			</center>
		</div>
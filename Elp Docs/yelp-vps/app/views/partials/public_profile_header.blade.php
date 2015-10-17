<div class="container full-content">

	<div class="row user-profile-header">
		<div class="col-md-9">
			<h3 style="display:inline-block;">{{$user->first_name}} {{$user->last_name}}'s Profile</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<div class="row user-profile-list">
				<?php $image = ($user->picture)?$user->picture:Config::get('database.default_profile_pic'); ?>
              <img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 100, 100) )}}">
				<li><i class="icon-group" style="color:blue;"></i><a href="#"> {{$friends->count()}} Friends</a></li>
				<li><i class="icon-star" style="color:orange;"></i><a href="#"> {{$user->reviews->count()}} Review</a></li>

				<p><span class="bold">Yelping since</span><br>
				{{date_format($user->created_at,'M Y')}}
				</p>
				@if(Sentry::check())
					@if(!isset($user->status))
						<a href="{{URL::route('addAsFriend',array('id'=>$user->id))}}"> Add as Friend </a>
					@elseif($user->status=="requestSent")
						Request Sent
					@elseif($user->status=="confirmRequest")
						<a href="{{URL::route('confirmFriendRequest',array('id'=>$user->id))}}"> Confim Request </a>
					@elseif($user->status=="accepted")
						Friends
					@endif
				@endif
			</div>
		</div>
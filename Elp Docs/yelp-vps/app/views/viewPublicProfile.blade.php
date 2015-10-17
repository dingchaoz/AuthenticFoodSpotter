@extends('layout')

@section('title',$user->first_name.' on '.Config::get('settings.title'))


@section('content')

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
				<li><i class="icon-group" style="color:blue;"></i> {{count($friends)}} Friends</li>
				<li><i class="icon-star" style="color:orange;"></i> {{$user->reviews->count()}} Reviews</li>

				<p><span class="bold">Yelping since</span><br>
				{{date_format($user->created_at,'M Y')}}
				</p>
				@if(Sentry::check())
				@if(Sentry::getUser()->id != $user->id)
				@if($user->follower)
						<div data-url="{{URL::route('follow',array('id'=>$user->id))}}" style="display:none;" class="follow btn btn-primary btn-md"> follow </div>
						<div data-url="{{URL::route('unfollow',array('id'=>$user->id))}}" class="unfollow btn btn-primary btn-md"> Unfollow </div>
					@else
						<div data-url="{{URL::route('follow',array('id'=>$user->id))}}" class="follow btn btn-primary btn-md"> follow </div>
						<div data-url="{{URL::route('unfollow',array('id'=>$user->id))}}" style="display:none;" class="unfollow btn btn-primary btn-md"> Unfollow </div>
					@endif
					<hr>
				@endif
				@endif
				@if(Sentry::check())
				@if(Sentry::getUser()->id != $user->id)
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
				@if(Sentry::check())
				@if(Sentry::getUser()->id != $user->id)
					<hr>
					
					<a href="#" class="sendMessage" data-toggle="modal" data-target="#sendMessage">Send Message</a>
				@endif
				@endif
				@endif
			</div>
		</div>

		<div class="col-md-7 user-profile-review">
			<div class="row">
				<div class="col-md-8">
					<h5>All Reviews</h5>
					<p>{{$user->reviews->count()}} reviews</p>
				</div>
			</div>
			<hr>

			@foreach($reviews as $review)
			<div class="row small-container-user-profile">
				<div class="col-md-9">
						<p class="bold"><a href="{{URL::route('viewBusiness',array('id'=>$review->business->id))}}">{{$review->business->name}}</a></p>
						<p>Category: <i class="icon-chevron-sign-right"></i><a href="{{URL::route('viewBusinessBySubCategory',array('id'=>$review->business->sub_category->id))}}"> {{$review->business->sub_category->sub_category}}</a></p>
						<div class="row">
							<div class="col-md-3">
								<div id="user-review-{{$review->id}}" style="width: 100px;"></div> 
							</div>
							<div class="col-md-3">
								{{date_format($review->updated_at,'d M y')}}
							</div>
						</div>{{nl2br($review->review)}}</p>
				</div>
				<div class="col-md-3 user-profile-address">
					<p>{{$review->business->street_no}} {{$review->business->street_name}}<br>
					{{$review->business->city->label}}, {{$review->business->state->label}} - {{$review->business->zipcode}}<br>
					{{$review->business->phone}}</p>
				</div>

				
			</div>
			<hr>
			@endforeach

			{{$reviews->links()}}
		</div>
		<div class="col-md-3 user-profile-sidebar">
			@if(count($friends)==0)
				<h4>0 Friends</h4>
			@else
				<h4>{{count($friends)}} Friends</h4>
			@endif

			<div class="row user-profile-sidebar-details">

			<?php $i = 0; ?>

			@foreach($friends as $friend)
				@if($i<28)
				@if(isset($friend->id))
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="row" style="padding: 5px;">
						<div class="col-md-12 col-sm-12 col-xs-12 profile-sidebar-pic">
							<?php $image = ($friend->picture)?$friend->picture:Config::get('database.default_profile_pic'); ?>
							<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
						</div>
						<p><a href="{{URL::route('viewPublicProfile',array('id'=>$friend->id))}}">{{ucfirst($friend->first_name)}} {{ucfirst($friend->last_name)}}</a></p>
					</div>
				</div>
				<?php $i++; ?>
				@endif
				@endif
			@endforeach
				
			<!-- <a href="{{URL::route('viewFriendsInPublicProfile',array('id'=>$user->id))}}" style="display:block; text-align:center; clear:both;"> See All Friends </a> -->
			</div>
		
			@if(count($user->followers)==0)
				<h4>0 Followers</h4>
			@else
				<h4>{{count($user->followers)}} Followers </h4>
			@endif

			<div class="row user-profile-sidebar-details">

			<?php $i = 0; ?>

			@foreach($user->followers as $follower)
				@if($i<28)
				<?php $follower = $follower->followers; ?>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="row" style="padding: 5px;">
						<div class="profile-sidebar-pic">
							<?php $image = ($follower->picture)?$follower->picture:Config::get('database.default_profile_pic'); ?>
							<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
						</div>
						<p><a href="{{URL::route('viewPublicProfile',array('id'=>$follower->id))}}">{{ucfirst($follower->first_name)}} {{ucfirst($follower->last_name)}}</a></p>
					</div>
				</div>
				<?php $i++; ?>
				@endif
			@endforeach
				
			<!-- <a href="{{URL::route('viewFriendsInPublicProfile',array('id'=>$user->id))}}" style="display:block; text-align:center; clear:both;"> See All Friends </a> -->
			</div>
		</div>
				
		</div>
	</div>
</div>

<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Send Message To <span id="receiverName"> {{$user->first_name}}</span></h4>
      </div>
      <form method="post" action="{{URL::route('sendMessage')}}">
        <div class="modal-body">
         <input type="text" class="form-control" id="receiverId" value="{{$user->id}}" name="to" style="display:none">

         <label> Subject : </label>
         <input type="text" class="form-control" name="subject">

         <label> Message : </label>
         <textarea name="message" class="form-control"> </textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.raty.js')}}"></script>
<script type="text/javascript">
 $( document ).ready(function() {


@foreach($user->reviews as $review)
    $('#user-review-{{$review->id}}').raty({
      starOff : "{{asset('img/star-off.png')}}",
      starOn : "{{asset('img/star-on.png')}}",
      starHalf : "{{asset('img/star-half.png')}}",
      half : true,
      readOnly : true,
      score : {{$review->score}}
    });
@endforeach

$('div.follow').on('click',function(){
	$.ajax({
		url:$(this).data('url')
	}).done(function(){
		$('.follow').hide();
		$('.unfollow').show();
	});
});

$('div.unfollow').on('click',function(){
	$.ajax({
		url:$(this).data('url')
	}).done(function(){
		$('.unfollow').hide();
		$('.follow').show();
	});
});

});


 






 </script>
@stop

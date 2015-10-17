@extends('layout')

@section('title',Config::get('settings.title').' dashboard')


@section('content')




<div class="container full-content">
	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12">
			<div class="row dashboard-header">
				<div class="col-md-5 col-sm-3 visible-md visible-lg col-xs-3">
					
					<h2 class="dashboard-h2">Recent Activity</h2>
					
				</div>
				<div class="col-md-7 col-sm-12 col-xs-12 nav-pill-super-class">
					<ul class="nav nav-pills dashboard-nav-pills">
						<li class="{{(!isset($_GET['by']))?'active':''}}"><a href="{{URL::route('dashboard')}}" >Explore</a></li>
						<li class="{{(isset($_GET['by'])&&$_GET['by']=='friends')?'active':''}}"><a href="{{URL::route('dashboard')}}?by=friends">Friends</a></li>
						<li class="{{isset($_GET['by'])&&($_GET['by']=='following')?'active':''}}"><a href="{{URL::route('dashboard')}}?by=following">Following</a></li>
						<li class="{{(isset($_GET['by'])&&$_GET['by']=='me')?'active':''}}"><a href="{{URL::route('dashboard')}}?by=me">Your Activity</a></li>
					</ul>
				</div>
			</div>
			@foreach($actions as $action)

			@if(isset($action->business))

			@if($action->action=="add_review"||$action->action=="update_review")
			<div class="row dashboard-review">
				<div class="col-md-1 col-sm-1 col-xs-3 dashboard-review-propic">
					<?php $image = ($action->user->picture)?$action->user->picture:Config::get('database.default_profile_pic'); ?>
					<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
				</div>
				<div class="col-md-11 col-sm-11 col-xs-9 dashboard-review-info">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-9"><span class="bold"><a href="{{URL::route('viewPublicProfile',array('id'=>$action->user->id))}}">{{$action->user->first_name}}</a></span>
						@if($action->action=="add_review")
							wrote a review for
						@elseif($action->action=="update_review")
							updated a review for
						@endif
						<a href="{{URL::route('viewBusiness',array('id'=>$action->business->id))}}">{{$action->business->name}}</a></div>
						<div class="col-md-3 col-sm-3 col-xs-3 dashboard-time" style="text-align:right;">{{$action->time}} ago</div>
					</div>
					<div class="row">
						<div class="col-md-2 col-sm-5 col-xs-5"><div id="dashboard-review-{{$action->id}}" style="width: 100px;"></div></div>
					</div>
					<div class="row dashboard-review-content">
						<p>{{nl2br($action->review)}}</p>
					</div>
					<!-- <p><span class="bold">Was this review..?</span></p>
					<div class="row dashboard-review-feedback">
						<div class="btn-group"> 
			              <button type="submit" class="btn"><i class="icon-lightbulb" style="color:orange;"></i> Useful</button>
			              <button type="submit" class="btn"><i class="icon-smile" style="color:green;"></i> Funny</button>
			              <button type="submit" class="btn"><i class="icon-thumbs-up" style="color:#0000f3;"></i> Cool 2</button>
			            </div>
					</div>
					<div class="row dashboard-review-comment">
						<div class="col-md-1 col-sm-1 col-xs-1" style="text-align:center;"><i class="icon-comment"></i></div>
						<div class="col-md-11 col-sm-11 col-xs-11"><input type="text" class="form-control" placeholder="Send a compliment"></div>
					</div> -->
				</div>
			</div>
			@elseif($action->action=="add_photo")
				<div class="row dashboard-review">
					<div class="col-md-1 col-sm-1 col-xs-3 dashboard-review-propic">
						<?php $image = ($action->user->picture)?$action->user->picture:Config::get('database.default_profile_pic'); ?>
						<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
					</div>
					<div class="col-md-11 col-sm-11 col-xs-9 dashboard-review-info">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-9"><span class="bold"><a href="{{URL::route('viewPublicProfile',array('id'=>$action->user->id))}}">{{$action->user->first_name}}</a></span> added a new photo to <a href="{{URL::route('viewBusiness',array('id'=>$action->business->id))}}">{{$action->business->name}}</a></div>
							<div class="col-md-3 col-sm-3 col-xs-3 dashboard-time" style="text-align:right;">{{$action->time}} ago</div>
						</div>
						<div class="row dashboard-review-content">
							<div class="col-md-6 col-sm-6 col-xs-6 review-pic">
								<a href="{{URL::route('viewBusinessGallery',array('id'=>$action->business->id))}}">
									<img src="{{ asset(Image::path('/uploads/'.$action->picture , 'resizeCrop', 300, 150) )}}">
								</a>
							</div>
						</div>
					</div>
				</div>
			@endif
			@endif
			@endforeach
			<!--<div class="row dashboard-review"> 
				<div class="col-md-1 col-sm-1 col-xs-1 dashboard-review-propic">
					<img src="http://s3-media4.ak.yelpcdn.com/photo/mT5Y0r2rRoX0gRzRun3xDQ/60s.jpg">
				</div>
				<div class="col-md-11 col-sm-11 col-xs-11 dashboard-review-info">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-9"><span class="bold"><a href="#">Thomas G.</a></span> added 2 new photos to <a href="#">The Beach Chalet Brewery & Restaurant</a></div>
						<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">A moment ago</div>
					</div>
					<div class="row dashboard-review-content">
						<div class="col-md-6 col-sm-6 col-xs-6 review-pic">
							<img src="http://s3-media3.ak.yelpcdn.com/bphoto/meldZttKP6y0erWHayoLDA/l.jpg">
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 review-pic">
							<img src="http://s3-media3.ak.yelpcdn.com/bphoto/meldZttKP6y0erWHayoLDA/l.jpg">
						</div>
					</div>
				</div>
			</div> -->
			@if(count($actions)==10)
			<center>
			<br>
				<a href="<?php if(!isset($_GET['page'])){ echo URL::route('dashboard').'/?page=2'; }else{ echo URL::route('dashboard').'/?page='.++$_GET['page']; }?>" class="btn btn-primary">
					More Activities					
				</a>
			</center>
			@endif
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12 dashboard-right-column">
		<div class="right-sidebar">		
			@if($featuredReview)
			<div class="row">
				<h2 class="dashboard-h2"> Review of the Day </h2>
				<div class="row dashboard-review" style="border:none;">
				<div class="col-md-3 col-sm-3 col-xs-3 dashboard-review-propic" style="padding-left: 15px;">
					<?php $image = ($featuredReview->user->picture)?$featuredReview->user->picture:Config::get('database.default_profile_pic'); ?>
					<a href="{{URL::route('viewPublicProfile',array('id'=>$featuredReview->user->id))}}">
					<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
					</a>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-9 dashboard-review-info">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-9"><span class="bold"><a href="{{URL::route('viewPublicProfile',array('id'=>$featuredReview->user->id))}}">{{$featuredReview->user->first_name}}</a></span>
						reviewed
						<a href="{{URL::route('viewBusiness',array('id'=>$featuredReview->business->id))}}">{{$featuredReview->business->name}}</a></div>
						
					</div>
					<div class="row">
						<div class="col-md-2 col-sm-5 col-xs-5"><div id="dashboard-featuredReview-{{$featuredReview->id}}" style="width: 100px;"></div></div>
						
					</div>
					<div class="row dashboard-review-content">
						<p>{{nl2br($featuredReview->review)}}</p>
					</div>
				</div>
			</div>
			</div>
			@endif
			<div class="row dashboard-user-details">
				<div class="row" style="height: 64px;">
					<div class="col-md-3 col-sm-4 col-xs-4">
					<?php $image = ($user->picture)?$user->picture:Config::get('database.default_profile_pic'); ?>
						<a href="{{URL::route('viewPublicProfile',array('id'=>$user->id))}}">
						<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 62, 62) )}}">
						</a>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-4">
						<p><i class="icon-group" style="color:#c42100;"></i> {{count($friends)}}</p>
						<p><i class="icon-star" style="color:#c42100;"></i> {{$noOfReviews}}</p>
					</div>
					<div class="col-md-7 col-sm-4 col-xs-4">
						<p class="bold"><a href="{{URL::route('viewProfile')}}" style="color:#3b5998">{{$user->first_name}} {{$user->last_name}}</a></p>
						<p> <a href="{{URL::Route('viewProfile')}}"> View Profile </a> </p>
					</div>
				</div>
				<hr style="clear:both; margin-top: 5px; margin-bottom: 10px;">
				<p> If your business is not listed then <a href="{{URL::route('newBusiness')}}" class="btn btn-primary"> Add your Business </a> </p>
			</div>

			<!-- <div class="row dashboard-review-stats">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p><i class="icon-lightbulb" style="color:orange;"></i> 0 Useful votes</p>
					<p><i class="icon-smile" style="color:green;"></i> 0 funny votes</p>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p><i class="icon-thumbs-up" style="color:blue"></i> 0 cool votes</p>
					<p><i class="icon-comment" style="color:red"></i> 0 Compliments</p>
				</div>
			</div> -->
			<div class="row dashboard-friend-requests">
			@if($friendRequests->count())
				<h3 style="color:#c42100;border-bottom:1px solid #ddd;font-weight:normal;">Pending Friend Request</h3>
				@foreach($friendRequests as $friendRequest)
				<div class="col-md-3 col-sm-4 col-xs-4">
					<?php $image = ($friendRequest->user->picture)?$friendRequest->user->picture:Config::get('database.default_profile_pic'); ?>
					<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 84, 84) )}}">
				</div>
				<!--<div class="col-md-2 col-sm-2 col-xs-2">
					 <p><i class="icon-group" style="color:#c42100;"></i> 2</p>
					<p><i class="icon-star" style="color:#c42100;"></i> 1</p> 
				</div>-->
				<div class="col-md-8 col-sm-8 col-xs-8">
					<p class="bold"><a href="{{URL::route('viewProfile',array('id'=>$friendRequest->user->id))}}" style="color:#3b5998">{{$friendRequest->user->first_name}} {{$friendRequest->user->last_name}}</a></p>
					<p><a href="{{URL::route('confirmFriendRequest',array('id'=>$friendRequest->user->id))}}" class="btn btn-primary">Confirm</a>
					<a href="{{URL::route('cancelFriendRequest',array('id'=>$friendRequest->user->id))}}" class="btn">Cancel</a></p>
				</div>
				@endforeach
			@endif
				

			</div>
			<div class="row">
				{{Config::get('settings.banner1')}}
			</div>
		</div>
		</div>
	</div>
</div>

@stop

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.raty.js')}}"></script>
<script type="text/javascript">
 $( document ).ready(function() {

@foreach($actions as $action)
	@if($action!=null && ($action->action=="add_review" || $action->action=="update_review"))
    $("#dashboard-review-{{$action->id}}").raty({
      starOff : "{{asset('img/star-off.png')}}",
      starOn : "{{asset('img/star-on.png')}}",
      starHalf : "{{asset('img/star-half.png')}}",
      half : true,
      readOnly : true,
      score : {{$action->score}}
    });
    @endif
@endforeach

@if($featuredReview)
    $("#dashboard-featuredReview-{{$featuredReview->id}}").raty({
      starOff : "{{asset('img/star-off.png')}}",
      starOn : "{{asset('img/star-on.png')}}",
      starHalf : "{{asset('img/star-half.png')}}",
      half : true,
      readOnly : true,
      score : {{$featuredReview->score}}
    });
@endif

});

 </script>

@stop
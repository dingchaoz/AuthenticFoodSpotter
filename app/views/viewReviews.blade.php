@extends('layout')

@section('title','user')

@section('content')
	
<?php

	$currentMenu = "reviews";

?>

@include('partials.profile_header')

		<div class="col-md-9 col-sm-9 col-xs-12 user-profile-review">
			<div class="row" style="border-bottom:1px solid #eee;">
				<div class="col-md-8 col-sm-8 col-xs-8" >
					<h5>All Reviews</h5>
					<p>{{$user->reviews->count()}} reviews</p>
				</div>
			</div>
			@foreach($user->reviews as $review)
			<div class="row small-container-user-profile">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-9 col-sm-6 col-xs-6">
							<p class="bold"><a href="{{URL::route('viewBusiness',array('id'=>$review->business->id))}}">{{$review->business->name}}</a></p>
							<p>Category: <i class="icon-chevron-sign-right"></i><a href="{{URL::route('viewBusinessBySubCategory',array('id'=>$review->business->sub_category->id))}}"> {{$review->business->sub_category->sub_category}}</a></p>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-6 user-profile-address">
							{{$review->business->street_no}} {{$review->business->street_name}}
							{{$review->business->city->label}}, {{$review->business->state->label}} - {{$review->business->zipcode}}
							{{$review->business->phone}}
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-5 col-xs-6">
							<div id="user-review-{{$review->id}}"></div> 
						</div>
						<div class="col-md-9 col-sm-7 col-xs-6">
							{{date_format($review->updated_at,'d M y')}}
						</div>
					</div>
					<div class="row profile-review-content">
						<p>{{$review->review}}</p>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="col-md-9 col-sm-6 col-xs-3 user-review-list">
						<!-- <li><a href="#"><i class="icon-envelope"></i> Send to a friend</a></li>
						<li><a href="#"><i class="icon-link"></i> Link to this review</a></li>
						<li><a href="#"><i class="icon-refresh"></i> Write an update</a></li> -->
					</div>
					<div class="col-md-3 col-sm-6 col-xs-9 user-review-list">
						<li><a href="{{URL::route('viewReview',array('id'=>$review->id))}}"><i class="icon-eye-open"></i> View </a></li>
						<li><a href="{{URL::route('writeReview',array('id'=>$review->business->id))}}"><i class="icon-edit"></i> Edit</a></li>
					</div>
				</div>
			<hr>
			@endforeach
				
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

});

 </script>
@stop
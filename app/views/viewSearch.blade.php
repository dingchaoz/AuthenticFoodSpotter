@extends('layout')

@section('title','Explore')

@section('content')


<div class="container full-content">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row search-header">
				<div class="col-md-9 col-sm-10 col-xs-6">
					<h2> {{$_GET['find']}} <span class="bold"> {{$_GET['near']}} </span></h2>
				</div>
				<div class="col-md-3 col-sm-2 col-xs-6">
					<!-- <p>showing 1 - 10 of 117</p> -->
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-sm-8 col-xs-12 search-left-side">
		@if($businesses->count())
			@foreach($businesses as $business)
			<div class="row search-result {{($business->featured_ad_expiry!='0000-00-00')?'featured':''}}">
				<div class="col-md-2 col-sm-4 col-xs-3">
				<?php
						if($business->photos->count()){
							$image = $business->photos[0]->picture;
						}else
						{
							$image = 'business_default.jpg';
						}
				?>
				<a href="{{URL::route('viewBusiness',array('id'=>$business->id))}}">
					<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
				</a>			
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<p><a href="{{URL::route('viewBusiness',array('id'=>$business->id))}}">{{$business->name}}</a></p>
					<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-6"><div id="search-review-{{$business->id}}" style="width: 100px;"></div></div>
						<div class="col-md-8 col-sm-6 col-xs-6 search-no-of-reviews"><p> {{$business->reviews->count()}} Reviews</p></div>
					</div>
					<p><a href="{{URL::route('viewBusinessBySubCategory',array('id'=>$business->sub_category->id))}}">{{$business->sub_category->sub_category}}</a></p>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6">
					<p>{{$business->street_no}} {{$business->street_name}}</p>
					<p>{{$business->city->label}}, {{$business->state->label}}</p>
					<p>{{$business->phone}}</p>
				</div>
			</div>
			@if($business->reviews->count())
			<div class="row search-result {{($business->featured_ad_expiry!='0000-00-00')?'featured':''}}">
				<?php $image = ($business->reviews[0]->user->picture)?$business->reviews[0]->user->picture:Config::get('database.default_profile_pic'); ?>
				<div class="col-md-1 col-xs-2 search-result-review"><img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 32, 32) )}}"></div>
				<div class="col-md-11 col-xs-10 search-result-review-content"><p>{{$business->reviews[0]->review}}</p></div>
			</div>
			@endif
			<hr/>
			@endforeach
		@endif
		<center>
			{{$businesses->appends(array('find' => $_GET['find'],'near' => $_GET['near']))->links()}}
		</center>
		</div>

		<div class="col-md-4 col-xs-12">
			<div class="well">
			<p> If your business is not listed then <a href="{{URL::route('newBusiness')}}" class="btn btn-primary"> Add your Business </a> </p>
			</div>
			<div class="row">
				{{Config::get('settings.banner1')}}
			</div>
		</div>
	</div>
</div>

@stop


@section('script')
<script type="text/javascript" src="{{asset('js/jquery.raty.js')}}"></script>
<script type="text/javascript">
 $( document ).ready(function() {

@if($businesses->count())
	@foreach($businesses as $business)
	    $('#search-review-{{$business->id}}').raty({
	      starOff : "{{asset('img/star-off.png')}}",
	      starOn : "{{asset('img/star-on.png')}}",
	      starHalf : "{{asset('img/star-half.png')}}",
	      half : true,
	      readOnly : true,
	      score : {{$business->rating}}
	    });
	@endforeach
@endif


});

 </script>
@stop
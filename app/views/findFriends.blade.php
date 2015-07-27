@extends('layout')

@section('title','Friends')

@section('content')


<div class="container full-content">
	<div class="row dashboard-header">
		<h3>Member Search Results</h3>
	</div>
	<div class="row friends-search">
		<form method="get" action="{{URL::route('findFriends')}}">
		<div class="col-md-3 col-sm-6 col-xs-10 friends-search-input">
			<input type="text" class="form-control" name="name" value="{{(isset($_GET['name']))?$_GET['name']:''}}">
		</div>
		<div class="col-md-1 col-sm-2 col-xs-2">
			<button type="submit" class="searchicon"><i class="icon-search"></i></button>
		</div>
		</form>
	</div>
	<div class="row friends-search-list">
		@foreach($users as $user)
		<div class="col-md-3 col-sm-4 col-xs-12 search-single-profile">
			<div class="row">
				<div class="col-md-5 col-sm-5 col-xs-6 friends-search-propic">
					<?php $image = ($user->picture)?$user->picture:Config::get('database.default_profile_pic'); ?>
					<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
				</div>
				<div class="col-md-7 col-sm-7 col-xs-6 friends-search-proname">
					<p><a href="{{URL::route('viewPublicProfile',array('id'=>$user->id))}}">{{$user->first_name}} {{$user->last_name}}</a></p>
					<!-- <p><button type="button" class="btn btn-sm btn-primary">Add Friend</button></p> -->
				</div>
			</div>
		</div>
		@endforeach
		
	</div>
</div>
@stop

@section('script')

@stop
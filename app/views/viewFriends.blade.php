@extends('layout')

@section('title',"Friends of ".$user->first_name)

@section('content')

<?php

	$currentMenu = 'friends';

?>

@include('partials.profile_header')
<div class="col-md-10 col-sm-12 col-xs-12 friends">
	<div class="row">
		@foreach($friends as $friend)
		<div class="col-md-2 col-sm-4 col-xs-4">
			<div class="padding">
				<div class="row">
					<?php $image = ($friend->picture)?$friend->picture:Config::get('database.default_profile_pic'); ?>
							<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 100, 100) )}}">					
				</div>
				<div class="row">
					<p><a href="{{URL::route('viewPublicProfile',array('id'=>$friend->id))}}">{{ucfirst($friend->first_name)}} {{ucfirst($friend->last_name)}}</a></p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
</div>
</div>
@stop

@section('script')



@stop
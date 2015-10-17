@extends('layout')

@section('title','Explore')

@section('content')
<div class="container">

<div class="row">
@foreach($countries as $country)
<div class="col-md-4">
<h1> {{$country->label}} </h1>
	<ul>
	@foreach($country->states as $state)
		<li><a href="{{URL::route('viewBusinessInState',array('id'=>$state->id))}}"> {{$state->label}} </a></li>
	@endforeach
	</ul>
</div>
@endforeach
</div>
</div>
@stop
@extends('layout')

@section('content')
<div class="container full-content">
	<div class="row">
		<div class="col-md-12 review-header">
			<div class="left">
				<p>Complete your review:</p>
				<p><a href="{{URL::route('viewBusiness',array('id'=>$business->id))}}">{{$business->name}}</a></p>
			</div>
			<div class="right">
				<p>{{$business->street_no}} {{$business->street_name}},</p>
				<p>{{$business->city->label}}, {{$business->state->label}} - {{$business->zipcode}}</p>
			</div>
		</div>
	</div>
	<form method="post" action="{{URL::route('addReview',array('id'=>$business->id))}}">
	<div class="row form-group">
		<div class="col-md-3">
			<p>Rating</p> 
		</div>
		<div class="col-md-2 stars">
			<div id="star"></div>
		</div>
		<div class="col-md-6">
			<div id="hint-id"></div>
		</div>
	</div>	
	<div class="row form-group">
		<div class="col-md-3">
			<p>Your Review</p>
		</div>
		<div class="col-md-9 review-area">
			<textarea class="form-control" rows="3" placeholder="Type your review here" name="review"><?php if(isset($review->id)){ echo $review->review; } ?></textarea>
		</div>
	</div>
	<div class="row form-group">
			<div class="col-md-1 col-sm-1 col-xs-3 right"><a href="{{URL::previous()}}" class="btn btn-primary btn-md searchicon">Cancel</a></div>
			<div class="col-md-1 col-sm-1 col-xs-3 right"><button type="submit" class="btn btn-primary btn-md searchicon">Save</button></div>
	</div>
	</form>
</div>

@stop

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.raty.js')}}"></script>

<script type="text/javascript">
	$('#star').raty({
	  starOff : "{{asset('img/star-off.png')}}",
      starOn : "{{asset('img/star-on.png')}}",
      starHalf : "{{asset('img/star-half.png')}}",
      half :false,
      hints : ['Eek. Me thinks Not.','Meh.I\'ve experienced better.','A-OK.','Yay!I\'m a fan','Woohoo! As good as it gets!'],
      target : "#hint-id",
      <?php 
      if(isset($review->id))
      {
      	echo "score : $review->score";
      } 
      ?>
	});
</script>
@stop
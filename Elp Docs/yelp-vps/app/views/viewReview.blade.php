@extends('layout')

@section('content')
	<div class="container">
	<a href="{{URL::route('viewBusiness',array('id'=>$review->business->id))}}">
	<h1> {{$review->business->name}} </h1>
	</a>
		<div class="row review">
        <div class="col-md-4">
          <div class="row review-profile">
            <div class="col-md-4 review-propic">
              <?php $image = ($review->user->picture)?$review->user->picture:Config::get('database.default_profile_pic'); ?>
              <img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 84, 84) )}}">
            </div>
            <div class="col-md-8 review-proinfo">
              <a href="#">{{$review->user->first_name}} {{$review->user->last_name}}</a>
              <p> </p>
              <p><i class="icon-group"></i>13 Friends</p>
              <p><i class="icon-star"></i>{{count($review->user->reviews)}} Reviews</p>
            </div>
          </div>
          <div class="row review-links">
              <p><a href="#"><i class="icon-share"></i>Share Review</a></p>
              <p><a href="#"><i class="icon-envelope"></i>Send Message</a></p>
              <p><a href="#"><i class="icon-heart"></i>Follow {{$review->user->first_name}} {{$review->user->last_name}}</a></p>
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-4">
              <div id="star"></div>
            </div>
            <div class="col-md-8">
              
            </div>
          </div>
          <div class="row review-content">
            <p>{{$review->review}}</p>
            
          </div>
          <!-- <div class="row review-buttons">
            <p>Was this review ...?</p>
            <div class="btn-group"> 
              <button type="submit" class="btn"><i class="icon-lightbulb" style="color:orange;"></i>Useful</button>
              <button type="submit" class="btn"><i class="icon-smile" style="color:green;"></i>Funny</button>
              <button type="submit" class="btn"><i class="icon-thumbs-up" style="color:#0000f3;"></i>Cool 2</button>
                <button type="submit" class="btn"><i class="icon-flag"></i></button>  
            </div>
          </div> -->
        </div>
      </div>
      </div>
@stop

@section('script')

<script type="text/javascript" src="{{asset('js/jquery.raty.js')}}"></script>
<script type="text/javascript">
 $( document ).ready(function() {
    $('#star').raty({
      starOff : "{{asset('img/star-off.png')}}",
      starOn : "{{asset('img/star-on.png')}}",
      starHalf : "{{asset('img/star-half.png')}}",
      half : true,
      readOnly : true,
      score : {{$review->score}}
    });


    $("[rel='tooltip']").tooltip();    
});
</script>
  

@stop
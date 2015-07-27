@extends('layout')

@section('title',$business->name.' on '.Config::get('settings.title'))

@section('head')

<meta name="description" content="{{$business->name}}, {{$business->sub_category->sub_category}}, {{$business->city->label}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-wysiwyg.css')}}">


@stop

@section('content')
<div class="container viewBusinesspage-container">
  <div class="row viewBusinesspage-belownav">
    @if(Sentry::check())
            @if($business->user_id == Sentry::getUser()->id)
              @if($business->featured_ad_expiry!='0000-00-00')
                <div class="alert alert-success">
                  You are the owner of this business. This business will be featured in {{Config::get('settings.title')}} till {{$business->featured_ad_expiry}}. <a href="{{URL::route('upgradeBusiness',array('id'=>$business->id))}}"> Click here to extend the validity </a>
                </div>
              @else
                <div class="alert alert-success">
                  You are the owner of this business. <a href="{{URL::route('upgradeBusiness',array('id'=>$business->id))}}"> Click here to make this business as featured </a>
                </div>
              @endif
            @endif
          @endif
    <div class="col-md-5 col-md-offset-1">
      <h1>{{$business->name}} {{ ($business->featured_ad_expiry!='0000-00-00')?'(Featured)':'' }} </h1>
      <div class="row">
      <div class="col-md-4">
       <div id="star"></div></div><div class="col-md-4"><p>{{$business->no_of_ratings}} Reviews <!-- <span class="details_business"><i class="icon-bar-chart"></i> Details</span> --></p></div>
       <div class="col-md-4"><p><a href="{{URL::route('viewBusinessBySubCategory',array('id'=>$business->sub_category->id))}}">{{$business->sub_category->sub_category}}</a><!-- <span class="details_business"><i class="icon-edit"></i>  Edit</span></p> --></div>
      </div>      
    </div>
    <div class="col-md-5 col-md-offset-1">
      <div class="buttons">
        @if(isset($review->id))
          <a href="{{URL::route('writeReview',array('id'=>$business->id))}}" class="btn btn-primary btn-md"><i class="icon-star"></i> Update your review </a>        
        @else
          <a href="{{URL::route('writeReview',array('id'=>$business->id))}}" class="btn btn-primary btn-md"><i class="icon-star"></i> Write a review</a>
        @endif
        <div class="btn-group">
          <button class="btn" data-toggle="modal" data-target="#myModal"><i class="icon-camera"></i> Add Photo</button>
          <button class="btn" data-toggle="modal" data-target="#businessShare"><i class="icon-share"></i> Share</button>
          <!-- <button class="btn"><i class="icon-bookmark"></i> Bookmark</button> -->
        </div>
      </div>
    </div>
  </div>
  <!-- All Photos -->
  <div class="row business-img-gallery">
    <div class="col-md-3 col-md-offset-1 xs-12 thumbnail-1">
      <div class="caption1">
        <img src="http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=300x135&maptype=roadmap&markers=color:red%7Clabel:%7C{{$business->lat}},{{$business->lon}}">
        <div class="address">{{$business->street_no}} {{$business->street_name}}, {{$business->city->label}}, {{$business->state->label}}, {{$business->country->label}}</div>
        <h5><a href="https://www.google.com/maps/search/{{$business->lat}},{{$business->lon}}" target="_blank">View in Google Maps</a></h5>
        <p><i class="icon-phone"></i> {{$business->phone}} </p>
        <p style="overflow: hidden; white-space: nowrap;"><i class="icon-link"></i> <a href="{{$business->website}}">  {{$business->website}} </a></p>
      </div>
    </div>


    @if($business->photos->count()==0)
      <div class="col-md-8 xs-12 thumbnail-1photo">
        <div class="btn-group">
            <button class="btn" data-toggle="modal" data-target="#myModal"><i class="icon-camera"></i>  Add Photo</button>
          </div>
      </div>
    @elseif($business->photos->count()==1)
      <div class="col-md-2 xs-12 thumbnail-2">
        <a href="{{URL::route('viewBusinessGallery',array('id'=>$business->id))}}"><img src="{{asset(Image::path('/uploads/'.$business->photos[0]->picture , 'resizeCrop', 250, 250) )}}" alt="{{$business->photos[0]->title}}"></a>
        <div class="caption-2"><p>{{$business->photos[0]->title}}</p></div>
      </div>
      <div class="col-md-6 xs-12 thumbnail-2photo">
        <div class="btn-group">
            <button class="btn" data-toggle="modal" data-target="#myModal"><i class="icon-camera"></i>  Add Photo</button>
          </div>
      </div>
    @elseif($business->photos->count()==2) 
      <div class="col-md-2 xs-12 thumbnail-2">
          <a href="{{URL::route('viewBusinessGallery',array('id'=>$business->id))}}"><img src="{{asset(Image::path('/uploads/'.$business->photos[0]->picture , 'resizeCrop', 250, 250) )}}" alt="{{$business->photos[0]->title}}"></a>
          <div class="caption-2"><p>{{$business->photos[0]->title}}</p></div>
      </div>
      <div class="col-md-3 xs-12 thumbnail-3">
          <a href="{{URL::route('viewBusinessGallery',array('id'=>$business->id))}}"><img src="{{asset(Image::path('/uploads/'.$business->photos[1]->picture , 'resizeCrop', 250, 250) )}}" alt="{{$business->photos[1]->title}}"></a>
          <div class="caption-3"><p>{{$business->photos[1]->title}}</p></div>
      </div>
      <div class="col-md-2 xs-12 thumbnail-3photo">
        <div class="btn-group">
            <button class="btn" data-toggle="modal" data-target="#myModal"><i class="icon-camera"></i>  Add Photo</button>
          </div>
      </div>

    @elseif($business->photos->count()>=3)
      <div class="col-md-2 xs-12 thumbnail-2">
            <a href="{{URL::route('viewBusinessGallery',array('id'=>$business->id))}}"><img src="{{asset(Image::path('/uploads/'.$business->photos[0]->picture , 'resizeCrop', 250, 250) )}}" alt="{{$business->photos[0]->title}}"></a>
          <div class="caption-2"><p>{{$business->photos[0]->title}}</p></div>
        </div>
        <div class="col-md-3 xs-12 thumbnail-3">
            <a href="{{URL::route('viewBusinessGallery',array('id'=>$business->id))}}"><img src="{{asset(Image::path('/uploads/'.$business->photos[1]->picture , 'resizeCrop', 250, 250) )}}" alt="{{$business->photos[1]->title}}"></a>
          <div class="caption-3"><p>{{$business->photos[1]->title}}</p></div>
        </div>
        <a href="{{URL::route('viewBusinessGallery',array('id'=>$business->id))}}">
          <div class="col-md-2 xs-12 thumbnail-4">
            <img src="{{asset(Image::path('/uploads/'.$business->photos[2]->picture , 'resizeCrop', 250, 250) )}}" alt="{{$business->photos[2]->title}}">
            <div class="caption-4"><p><i class="icon-link"></i> See all Photos</p>
          </div>
        </a>
      </div>


    @endif
   <!--  <div class="col-md-2 xs-12 thumbnail-2">
        <a href="#"><img src="http://s3-media2.fl.yelpcdn.com/bphoto/W47DajoMvbRKtKLGmUm_GQ/ls.jpg" alt="..."></a>
        <div class="caption-2"><p>Whatever it is!</p></div>
    </div>
    <div class="col-md-3 xs-12 thumbnail-3">
        <a href="#"><img src="http://s3-media2.fl.yelpcdn.com/bphoto/-plTfwdL1yeXqtGMaXwHIg/ls.jpg" alt="..."></a>
        <div class="caption-3"><p>Another Description</p></div>
    </div>
    <div class="col-md-2 xs-12 thumbnail-4">
      <a href="#"><img src="http://s3-media1.fl.yelpcdn.com/bphoto/qAztaY88NsxpvkUlqFxX_g/168s.jpg" alt="..."></a>
      <div class="caption-4"><p><i class="icon-link"></i> See all Photos</p>
    </div>
  </div>
 -->
   <!-- USE THIS
  <div class="row business-img-gallery">
    <div class="col-md-3 col-md-offset-1 xs-12 thumbnail-1">
      <div class="caption1">
        <img src="http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=300x135&maptype=roadmap&markers=color:red%7Clabel:%7C{{$business->lat}},{{$business->lon}}">
        <div class="address">{{$business->street_no}} {{$business->street_name}}, {{$business->city->label}}, {{$business->state->label}}, {{$business->country->label}}</div>
        <h5><a href="https://www.google.com/maps/search/{{$business->lat}},{{$business->lon}}" target="_blank">View in Google Maps</a></h5>
        <p><i class="icon-phone"></i> {{$business->phone}} </p>
        <p><i class="icon-link"><a href="{{$business->website}}">  {{$business->website}} </a></i></p>
        <p style="visibility:hidden;margin-bottom:0px;">asdasd</p>
      </div>
    </div>
    <div class="col-md-2 xs-12 thumbnail-2">
        <a href="#"><img src="http://s3-media2.fl.yelpcdn.com/bphoto/W47DajoMvbRKtKLGmUm_GQ/ls.jpg" alt="..."></a>
        <div class="caption-2"><p>Whatever it is!</p></div>
    </div>
    <div class="col-md-3 xs-12 thumbnail-3">
        <a href="#"><img src="http://s3-media2.fl.yelpcdn.com/bphoto/-plTfwdL1yeXqtGMaXwHIg/ls.jpg" alt="..."></a>
        <div class="caption-3"><p>Another Description</p></div>
    </div>
    <div class="col-md-2 xs-12 thumbnail-3photo">
      <div class="btn-group">
          <button class="btn"><i class="icon-camera"></i>  Add Photo</button>
        </div>
    </div>
  </div>

  <div class="row business-img-gallery">
    <div class="col-md-3 col-md-offset-1 xs-12 thumbnail-1">
      <div class="caption1">
        <img src="http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=300x135&maptype=roadmap&markers=color:red%7Clabel:%7C{{$business->lat}},{{$business->lon}}">
        <div class="address">{{$business->street_no}} {{$business->street_name}}, {{$business->city->label}}, {{$business->state->label}}, {{$business->country->label}}</div>
        <h5><a href="https://www.google.com/maps/search/{{$business->lat}},{{$business->lon}}" target="_blank">View in Google Maps</a></h5>
        <p><i class="icon-phone"></i> {{$business->phone}} </p>
        <p><i class="icon-link"><a href="{{$business->website}}">  {{$business->website}} </a></i></p>
        <p style="visibility:hidden;margin-bottom:0px;">asdasd</p>
      </div>
    </div>
    <div class="col-md-2 xs-12 thumbnail-2">
        <a href="#"><img src="http://s3-media2.fl.yelpcdn.com/bphoto/W47DajoMvbRKtKLGmUm_GQ/ls.jpg" alt="..."></a>
        <div class="caption-2"><p>Whatever it is!</p></div>
    </div>
    <div class="col-md-6 xs-12 thumbnail-2photo">
      <div class="btn-group">
          <button class="btn"><i class="icon-camera"></i>  Add Photo</button>
        </div>
    </div>
  </div>

  <div class="row business-img-gallery">
    <div class="col-md-3 col-md-offset-1 xs-12 thumbnail-1">
      <div class="caption1">
        <img src="http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=300x135&maptype=roadmap&markers=color:red%7Clabel:%7C{{$business->lat}},{{$business->lon}}">
        <div class="address">{{$business->street_no}} {{$business->street_name}}, {{$business->city->label}}, {{$business->state->label}}, {{$business->country->label}}</div>
        <h5><a href="https://www.google.com/maps/search/{{$business->lat}},{{$business->lon}}" target="_blank">View in Google Maps</a></h5>
        <p><i class="icon-phone"></i> {{$business->phone}} </p>
        <p><i class="icon-link"><a href="{{$business->website}}">  {{$business->website}} </a></i></p>
        <p style="visibility:hidden;margin-bottom:0px;">asdasd</p>
      </div>
    </div>
    <div class="col-md-8 xs-12 thumbnail-1photo">
      <div class="btn-group">
          <button class="btn"><i class="icon-camera"></i>  Add Photo</button>
        </div>
    </div>
  </div>
  USE THIS -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    @if(Sentry::check())
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Photos</h4>
      </div>
      <form role="form" method="post" action="{{URL::route('addBusinessPhoto',array('id'=>$business->id))}}" enctype = "multipart/form-data">
      <div class="modal-body">
          <div class="form-group">
            <label>Photo</label>
            <input type="file" name="photo" required>
          </div>
          <div class="form-group">
            <label>Caption</label>
            <input class="form-control" name="caption"/>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    @else
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Login / Register</h4>
      </div>
      <div class="modal-body">
          Please <a href="{{'login'}}"> Login/Register </a> to add photos.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    @endif
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Send Message To <span id="receiverName"> </span></h4>
      </div>
      <form method="post" action="{{URL::route('sendMessage')}}">
        <div class="modal-body">
         <input type="text" class="form-control" id="receiverId" name="to" style="display:none">

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
</div></div>
<div class="row viewBusiness-bottom-wrap">
    <div class="col-md-9">

      <h2 class="dashboard-h2" style="margin-bottom: 10px;"> Recent Reviews </h2>     
      <hr>

      @if(!$business->reviews->count())
        <center> Not yet reviewed :( </center>
      @endif
      @foreach($business->reviews as $review)
      <div class="row review">
        <div class="col-md-4">
          <div class="row review-profile">
            <div class="col-md-4 col-xs-6 review-propic">
              <?php $image = ($review->user->picture)?$review->user->picture:Config::get('database.default_profile_pic'); ?>
              <img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 84, 84) )}}">
            </div>
            <div class="col-md-8 col-xs-6 review-proinfo">
              <a href="{{URL::Route('viewPublicProfile',array('id'=>$review->user->id))}}">{{$review->user->first_name}} {{$review->user->last_name}}</a>
              <p> </p>
              <p><i class="icon-group"></i>{{$review->user->friends->count()+$review->user->friendsWithMe->count()}} Friends</p>
              <p><i class="icon-star"></i>{{count($review->user->reviews)}} Reviews</p>
            </div>
          </div>
          <div class="row review-links">
              <p><a href="#"><i class="icon-share"></i>Share Review</a></p>
              <p><a href="#" data-id="{{$review->user->id}}" data-name="{{$review->user->first_name}}" class="sendMessage" data-toggle="modal" data-target="#sendMessage"><i class="icon-envelope"></i>Send Message</a></p>
              <!-- <p><a href="#"><i class="icon-heart"></i>Follow {{$review->user->first_name}} {{$review->user->last_name}}</a></p> -->
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-4">
              <div id="review-{{$review->id}}"></div>
            </div>
            <div class="col-md-8">
              
            </div>
          </div>
          <div class="row review-content">
            <p>{{nl2br($review->review)}}</p>
            
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
      @endforeach
      


    </div>
    <div class="col-md-3">

      <div class="side-column-top">
        <div class="row side-column">
          <div class="col-md-3 col-sm-3 col-xs-3">
            <center><i class="icon-pencil" style="font-size:18px;color:red;"></i></center>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-9">
            <span style="font-weight:bold;"><a href="{{URL::route('editBusiness',array('id'=>$business->id))}}">Edit business info</a></span>
          </div> 
        </div>
          @if($business->user_id==0)
        <div class="row side-column">
          <div class="col-md-3 col-sm-3 col-xs-3">
            <center><i class="icon-suitcase" style="font-size:18px;color:brown;"></i></center>
          </div>
          <div class="col-md-9 col-sm-9 col-xs-9">
            <a href="{{URL::route('claimRequest',array('id'=>$business->id))}}"><span style="font-weight:bold;">Work Here ?</span> claim this business! </a>
          </div>
        </div>
          @endif
          @if(Sentry::check())
                @if($business->user_id == Sentry::getUser()->id)
                <div class="row side-column">
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <center><i class="icon-pencil" style="font-size:18px;color:brown;"></i></center>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-3">
                    <a href="#" data-toggle="modal" data-target="#editBusinessHours"><span style="font-weight:bold;">&nbsp;&nbsp;Edit Business Hours</span> </a>
                  </div>
                </div>
                <div class="row side-column">
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <center><i class="icon-pencil" style="font-size:18px;color:brown;"></i></center>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-3">
                    <a href="#"  data-toggle="modal" data-target="#editMore"><span style="font-weight:bold;">&nbsp;&nbsp;Edit More Info</span> </a>
                  </div>
                </div>
                @endif
          @endif


          </div>
                

      <div class="row side-column-bottom" style="padding-left: 10px;">
      @if($times)
          <h4>Business Hours</h4>
          <p><b> Mon : </b> {{(isset($times[0]))?$times[0]:''}} </p>
          <p><b> Tue : </b> {{(isset($times[1]))?$times[1]:''}} </p>
          <p><b> Wed : </b> {{(isset($times[2]))?$times[2]:''}} </p>
          <p><b> Thu : </b> {{(isset($times[3]))?$times[3]:''}} </p>
          <p><b> Fri : </b> {{(isset($times[4]))?$times[4]:''}} </p>
          <p><b> Sat : </b> {{(isset($times[5]))?$times[5]:''}} </p>
          <p><b> Sun : </b> {{(isset($times[6]))?$times[6]:''}} </p>
          <br>
      @endif
      @if($business->more_info)
          <h4>More business info</h4>
          {{$business->more_info}}
      @endif
        </div> 
      </div>
      </div>
    </div>
  </div>

<div class="modal fade" id="businessShare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Share Business</h4>
      </div>
      <div class="modal-body">
          <div class="row" style="margin-bottom: 10px">
            <div class="col-md-6">
             <a href="https://www.facebook.com/sharer/sharer.php?u={{URL::route('viewBusiness',array('id'=>$business->id))}}" target="_blank" class="btn btn-info col-md-10 col-md-offset-1"> Facebook </a>
            </div>
            <div class="col-md-6">
             <a href="https://www.twitter.com/share" target="_blank" class="btn btn-info col-md-10 col-md-offset-1" style="margin-left: 20px;"> Twitter </a>
            </div>
          </div>
          <input type="text" class="form-control" placeholder="Share URL" value="{{URL::route('viewBusiness',array('id'=>$business->id))}}">
      </div>
    </div>
  </div>
</div>



@if(Sentry::check())
  @if($business->user_id == Sentry::getUser()->id)
    <div class="modal fade" id="editBusinessHours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Edit Business Hours</h4>
          </div>
           <form method="post" action="{{URL::route('updateBusinessHours',array('id'=>$business->id))}}">
              <div class="modal-body">

               <label> Mon : </label>
               <input type="text" class="form-control" name="mon" value="{{(isset($times[0]))?$times[0]:''}}">

               <label> Tue : </label>
               <input type="text" class="form-control" name="tue" value="{{(isset($times[1]))?$times[1]:''}}">
               
               <label> Wed : </label>
               <input type="text" class="form-control" name="wed" value="{{(isset($times[2]))?$times[2]:''}}">

               <label> Thu : </label>
               <input type="text" class="form-control" name="thu" value="{{(isset($times[3]))?$times[3]:''}}">

               <label> Fri : </label>
               <input type="text" class="form-control" name="fri" value="{{(isset($times[4]))?$times[4]:''}}">

               <label> Sat : </label>
               <input type="text" class="form-control" name="sat" value="{{(isset($times[5]))?$times[5]:''}}">

               <label> Sun : </label>
               <input type="text" class="form-control" name="sun" value="{{(isset($times[6]))?$times[6]:''}}">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send</button>
              </div>
            </form>   
              
          </div>
        </div>
      </div>
    </div>    

<div class="modal fade" id="editMore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Edit More Info</h4>
          </div>
           <form method="post" action="{{URL::route('updateMoreInfo',array('id'=>$business->id))}}">
              <div class="modal-body wysiwyg">
                  <textarea name="moreInfo" class="form-control" placeholder="HTML Supported space. You can add more information about your business here." style="height: 300px;">{{$business->more_info}}</textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Send</button>
              </div>
            </form>   
              
          </div>
        </div>
      </div>
    </div>    

  @endif
@endif
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
      score : {{$business->rating}}
    });

    @foreach($business->reviews as $review)

    $('#review-{{$review->id}}').raty({
      starOff : "{{asset('img/star-off.png')}}",
      starOn : "{{asset('img/star-on.png')}}",
      starHalf : "{{asset('img/star-half.png')}}",
      readOnly : true,
      score : {{$review->score}}
    });

    @endforeach

    $("[rel='tooltip']").tooltip();    

    $('.sendMessage').on('click',function(){
      $('#receiverId').val($(this).data('id'));
      $('#receiverName').html($(this).data('name'));
    });

    $('.thumbnail-4,.thumbnail-2').hover(function(){
      $('.thumbnail-3').css({
        'transform':'scale(0.69)',
        '-ms-transform':'scale(0.69)',
        '-moz-transform':'scale(0.69)',
        '-webkit-transform':'scale(0.69)',
        '-o-transform':'scale(0.69)'
      }), $('.caption-3').css({
          'z-index':-2        
      });
    },function(){
      $('.thumbnail-3').css({
        'transform':'scale(1.00)',
        '-ms-transform':'scale(1.00)',
        '-moz-transform':'scale(1.00)',
        '-webkit-transform':'scale(1.00)',
        '-o-transform':'scale(1.00)'
      }), $('.caption-3').css({
        'z-index':2
      });
    });
});
</script>
<script type="text/javascript" src="{{asset('js/wysihtml5.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-wysiwyg.js')}}"></script>

<script type="text/javascript">
  $('textarea').wysihtml5();
</script>
@stop
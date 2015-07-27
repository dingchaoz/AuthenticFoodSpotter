@extends('layout')

@section('title',Config::get('settings.title'))


@section('content')

<div class="welcome-container full-content">
	<div class="row">
		<div class="col-md-8 col-sm-12 col-xs-12">
			<div class="row dashboard-header">
				<div class="welcome-content">
				<h3 class="dashboard-h2"> {{Config::get('settings.title')}} is the best way to find great local businesses</h3>
				<p> People use {{Config::get('settings.title')}} to search for everything from the city's tastiest burger to the most renowned cardiologist. What will you uncover in your neighborhood? </p>
				<a href="{{URL::route('register')}}" class="btn btn-primary"> Create Your Free Account </a>
				</div>
			</div>

			<div class="row best-of-elp-header">
				<div class="col-md-12 col-sm-3 visible-md visible-lg col-xs-3 ">
					<h3 class="dashboard-h2">Better than Yelp</h3>
				</div>
			</div>
			<div class="row best-of-elp">
				<div class="col-md-3 col-sm-12 col-xs-12 best-of-elp-nav">
					<ul class="nav nav-pills nav-stacked">
					<?php $k = 0; ?>
					@foreach($categories as $category)
						<li class="<?php if($k==0){ echo 'active'; $k = 1; }else{  } ?>"><a href="#type-{{$category->id}}" data-toggle="tab">
							<div class="row">
								<div class="col-md-12 best-of-elp-nav-item">
									<p>{{$category->category_name}}</p>
									<p>{{$category->businesses->count()}} Businesses Reviewed</p>
								</div>
							</div>	
						</a></li>
					@endforeach
						
					</ul>
				</div>
				<div class="col-md-9 col-sm-12 col-xs-12 best-of-elp-content">
					<div class="tab-content">
					<?php $j = 0; ?>
					@foreach($categories as $category)
						<div class="tab-pane fade <?php if($j!=0){ $j++; }else{ echo 'in active'; $j = 1; }?>	" id="type-{{$category->id}}">
							<div class="row">
								<div class="col-md-9 col-xs-6 best-of-elp-topic">
									<h4>{{ucfirst($category->category_name)}}</h4>
								</div>
								<div class="col-md-3 col-xs-6 best-of-elp-seemore">
									<a href="{{URL::route('viewBusinessByCategory',array('id'=>$category->id))}}"> See More</a>
								</div>
							</div>
							<?php $i = 0; ?>
							@foreach($category->businesses as $business)
								@if($i<4)
									<div class="row best-of-elp-nav-reviews">
										<div class="col-md-2 col-sm-2 col-xs-2 best-of-elp-nav-review-pic">
											<?php
													if($business->photos->count()){
														$image = $business->photos[0]->picture;
													}else
													{
														$image = 'business_default.jpg';
													}
											?>
											<a href="{{URL::route('viewBusiness',array('id'=>$business->id))}}">
												<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}"/>
											</a>
										</div>
										<div class="col-md-10 col-sm-10 col-xs-10 best-of-elp-nav-review-info">
											<div class="row">
												<div class="col-md-12">
													<p style="margin:0px;"><a href="{{URL::route('viewBusiness',array('id'=>$business->id))}}">{{$business->name}}</a></p>
												</div>
											</div>
											<div class="row">
												<div class="col-md-5 col-sm-5 col-xs-12">
													<div id="business-review-{{$business->id}}" style="width: 100px;"></div>
												</div>
												<div class="col-md-7 col-sm-7 hidden-xs col-xs-12">
													<p style="color:#000;">{{$business->reviews->count()}} Reviews</p>
												</div>
											</div>
											@if($business->reviews->count())
											<div class="row">
												<div class="col-md-2 col-sm-2 col-xs-2 best-of-elp-nav-review-propic">
													<?php $image = ($business->reviews[0]->user->picture)?$business->reviews[0]->user->picture:Config::get('database.default_profile_pic'); ?>
													<a href="{{URL::route('viewPublicProfile',array('id'=>$business->reviews[0]->user->id))}}">
														<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 32, 32) )}}">	
													</a>
												</div>
												<div class="col-md-10 col-sm-10 col-xs-10 best-of-elp-nav-review-content">
													<p>{{$business->reviews[0]->review}}</p>
												</div>
											</div>
											@else
											<br><br>
											@endif

										</div>
									</div>

									<?php $i++; ?>
								@endif
							@endforeach
						</div>
					@endforeach
					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 recent-activity">
					<h3>Recent-activity</h3>
				</div>
			</div>
			@foreach($actions as $action)
			@if(isset($action->business))
			@if($action->action=="add_review"||$action->action=="update_review")
			<div class="row dashboard-review">
				<div class="col-md-1 col-sm-1 col-xs-1 dashboard-review-propic">
					<?php $image = ($action->user->picture)?$action->user->picture:Config::get('database.default_profile_pic'); ?>
					<a href="{{URL::route('viewPublicProfile',array('id'=>$action->user->id))}}">
						<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
					</a>
				</div>
				<div class="col-md-11 col-sm-11 col-xs-11 dashboard-review-info">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-9"><span class="bold"><a href="{{URL::route('viewPublicProfile',array('id'=>$action->user->id))}}">{{$action->user->first_name}}</a></span>
						@if($action->action=="add_review")
							wrote a review for
						@elseif($action->action=="update_review")
							updated a review for
						@endif
						<a href="{{URL::route('viewBusiness',array('id'=>$action->business->id))}}">{{$action->business->name}}</a></div>
						<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">{{$action->time}} ago</div>
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
					<div class="col-md-1 col-sm-1 col-xs-1 dashboard-review-propic">
						<?php $image = ($action->user->picture)?$action->user->picture:Config::get('database.default_profile_pic'); ?>
						<a href="{{URL::route('viewPublicProfile',array('id'=>$action->user->id))}}">
						<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64) )}}">
						</a>
					</div>
					<div class="col-md-11 col-sm-11 col-xs-11 dashboard-review-info">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-9"><span class="bold"><a href="{{URL::route('viewPublicProfile',array('id'=>$action->user->id))}}">{{$action->user->first_name}}</a></span> added a new photo to <a href="{{URL::route('viewBusiness',array('id'=>$action->business->id))}}">{{$action->business->name}}</a></div>
							<div class="col-md-3 col-sm-3 col-xs-3" style="text-align:right;">{{$action->time}} ago</div>
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
		<div class="col-md-4 col-sm-6 col-xs-12 hidden-sm dashboard-right-column">
		<div class="right-sidebar">
			@if($featuredReview)
			<div class="row">
				<h2 class="dashboard-h2"> Review of the Day </h2>
				<div class="row dashboard-review">
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
			<div class="row">
				{{Config::get('settings.banner1')}}
			</div>
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

@foreach($categories as $category)
	@foreach($category->businesses as $business)
	 	$('#business-review-{{$business->id}}').raty({
	 		starOff:"{{ asset('img/star-off.png') }}",
	 		starOn:"{{ asset('img/star-on.png') }}",
	 		starHalf : "{{ asset('img/star-half.png') }}",
	 		half : true,
	 		readOnly: true,
	 		score : {{$business->rating}}
	 	});
 	@endforeach
 @endforeach

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
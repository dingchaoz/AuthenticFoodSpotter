<?php
use Omnipay\Omnipay;

class BusinessController extends \BaseController {

	public function newBusiness(){
		$user = Sentry::getUser();
		$categories = Category::where('active',1)->get();
		return View::make('newBusiness')->withUser($user)->withCategories($categories);
	}

	public function addBusiness(){


		$old_business = Business::where('name',Input::get('name'))->where('street_number',Input::get('street_number'))->where('street_name',Input::get('street_name'))->first();

		if(isset($old_business->id))
		{
			return Redirect::route('viewBusiness',array('id'=>$old_business->id))->withError('Duplicate business detected ! This business looks similar to your business');	
		}

		$business = new Business;

		$business->name = Input::get('name');
		$business->street_no = Input::get('street_number');
		$business->street_name = Input::get('street_name');

		$country = Country::firstOrCreate(array('label' => Input::get('country')));
		$business->country_id = $country->id;

		$state = State::firstOrCreate(array('label' => Input::get('state'),'country_id' => $country->id));
		$business->state_id = $state->id;

		$city = City::firstOrCreate(array('label'=>Input::get('city'),'state_id'=>$state->id,'country_id'=>$country->id));
		$business->city_id = $city->id;		
		
		$business->zipcode = Input::get('zipcode');
		$business->lat 	= Input::get('lat');
		$business->lon 	= Input::get('lon');
		$business->phone	= Input::get('phone');
		$business->website	= Input::get('website');
		$business->rating 	= '0';
		$business->no_of_ratings	= '0';
		$business->category_id	= Input::get('category');
		$business->sub_category_id = Input::get('sub_category');


		$business->save();


		if(Input::get('featured')=="true")
		{

			$gateway = Omnipay::create('PayPal_Express');
	      $gateway->setUsername(Config::get('paypal.username'));
	      $gateway->setPassword(Config::get('paypal.password'));
	      $gateway->setSignature(Config::get('paypal.signature'));
	      $gateway->setTestMode(Config::get('paypal.testmode'));

			$response = $gateway->purchase(
			                    array(
			                        'cancelUrl' => URL::route('failedPayment'),
			                        'returnUrl' => URL::route('successPayment',array('id'=>$business->id)), 
			                        'amount' => (double)Config::get('settings.featuredAdCost'),
			                        'currency' => 'USD',
			                        'description'	=> 'Featured business for $'.Config::get('settings.featuredAdCost').'/month'
			                    )
			            )->send();



			$response->redirect();
		}
		else
		{
			return Redirect::route('viewBusiness',array('id'=>$business->id))->withSuccess('Business added successfully');	
		}
		

	}

	public function getSubcategory($id){
		$category = Category::find($id);
		$sub_categories = $category->sub_categories()->get();
		return View::make('getSubcategory')->withSub_categories($sub_categories);
	}

	public function editBusiness($id){

		$user = Sentry::getUser();
		$business = Business::where('id',$id)->with('city','state','country','user','category','sub_category')->first();
		return View::make('editBusiness')->withBusiness($business)->withUser($user);

	}

	public function viewBusinessGallery($id)
	{
		
		$business = Business::where('id',$id)->with('city','state','country','user')->first();
		$photos = Business_photo::where('business_id',$business->id)->paginate(12);
		if(Sentry::check())
		{
			$user = Sentry::getUser();
			$admin = Sentry::findGroupByName('admin');
		  	if($user->inGroup($admin))
		  	{
		  		$user->admin = 1;
		  	}
		  	else
		  	{
		  		$user->admin = 0;
		  	}

		  	return View::make('viewBusinessGallery')->withUser($user)->withBusiness($business)->withPhotos($photos);
		}
		else
		{
			return View::make('viewBusinessGallery')->withBusiness($business)->withPhotos($photos);
		}

		
	}

	public function businessReview($id){
		$user = Sentry::getUser();
		return View::make('businessReview')->withUser($user);
	}
	public function updateBusinessRequest($id){

		$user = Sentry::getUser();
		$business = Business::find($id);

		if($business->user_id == $user->id)
		{
	        $business->name = Input::get('name');
	        $business->street_no = Input::get('street_number');
	        $business->street_name = Input::get('street_name');

	         $country = Country::firstOrCreate(array('label' => Input::get('country')));
	        $business->country_id = $country->id;

	        $state = State::firstOrCreate(array('label' => Input::get('state'),'country_id' => $country->id));
	        $business->state_id = $state->id;

	        $city = City::firstOrCreate(array('label'=>Input::get('city'),'state_id'=>$state->id,'country_id'=>$country->id));
	        $business->city_id = $city->id;
	        
	        
	        $business->zipcode = Input::get('zipcode');
	        $business->lat  = Input::get('lat');
	        $business->lon  = Input::get('lon');
	        $business->phone  = Input::get('phone');
	        $business->website  = Input::get('website');
	        $business->save();

	        return Redirect::route('dashboard')->withSuccess('Your Edits are updated successfully');
	       
		}
		else
		{
			$edit_log = new Edit_log;
			$edit_data['name'] = Input::get('name');
			$edit_data['street_no'] = Input::get('street_number');
			$edit_data['street_name'] = Input::get('street_name');


			$edit_data['country'] = Input::get('country');
			$edit_data['state'] = Input::get('state');

			$edit_data['city'] = Input::get('city');
			
			
			$edit_data['zipcode'] = Input::get('zipcode');
			$edit_data['lat'] 	= Input::get('lat');
			$edit_data['lon'] 	= Input::get('lon');
			$edit_data['phone']	= Input::get('phone');
			$edit_data['website']	= Input::get('website');

			$user = Sentry::getUser();

			$edit_log->edits = json_encode($edit_data);

			$edit_log->user_id = $user->id;

			$edit_log->business_id = $id;

			$edit_log->save();

			return Redirect::route('dashboard')->withSuccess('Your Edit have been submitted successfully');
	
		}

		
	}

	public function writeReview($id){
		$business = Business::find($id);
		$user = Sentry::getUser();
		$review = Review::where('user_id',$user->id)->where('business_id',$business->id)->first();
		return View::make('writeReview')->withBusiness($business)->withUser($user)->withReview($review);
	}

	public function addReview($id){
		$user = Sentry::getUser();
		$business = Business::find($id);

		$current_review = Review::where('user_id',$user->id)->where('business_id',$business->id)->first();

		if(isset($current_review->id))
		{
			if($business->no_of_ratings != 1){
				$business->rating = (($business->rating*$business->no_of_ratings)-$current_review->score)/($business->no_of_ratings-1);
				$business->no_of_ratings = $business->no_of_ratings-1;	
			}else{
				$business->rating = 0;
				$business->no_of_ratings = 0;
			}

			Activity::where('reference_id',$current_review->id)->whereIn('action',array('add_review','update_review'))->delete();
			
			$business->save();
			Review::where('user_id',$user->id)->where('business_id',$business->id)->delete();
			$flag = 1;
		}

		$review = new Review;
		$review->score = Input::get('score');
		$review->user_id = $user->id;
		$review->business_id = $id;
		$review->review = Input::get('review');

		$review->save();

		$activity = new Activity;
		$activity->user_id = $user->id;
		if(isset($flag))
			$activity->action = 'update_review';
		else
			$activity->action = 'add_review';
		$activity->reference_id = $review->id;
		$activity->save();

		$business->rating = (($business->rating*$business->no_of_ratings)+$review->score)/($business->no_of_ratings+1);

		$business->no_of_ratings = $business->no_of_ratings+1;

		$business->save();

		return Redirect::route('viewBusiness',array('id'=>$id))->withSuccess('Your rating added successfully');

	}

	public function claimRequest($id)
	{
		$business = Business::find($id);
		if($business->user_id!=0)
		{
			return Redirect::route('viewBusiness',array('id'=>$id))->withError('This business is claimed already. Contact the support if it is your\'s');
		}

		$previousRequest = Claim_request::where('user_id',Sentry::getUser()->id)->where('business_id',$id)->first();

		if(isset($previousRequest->id))
		{
			return Redirect::route('viewBusiness',array('id'=>$id))->withError('Claim request sent already.');	
		}

		$claim_request = new Claim_request;
		$claim_request->user_id = Sentry::getUser()->id;
		$claim_request->business_id = $id;
		$claim_request->save();

		return Redirect::route('viewBusiness',array('id'=>$id))->withSuccess('Your claim has been sent for approval');

	}

	public function viewReview($id)
	{
		$review = Review::where('id',$id)->with('business','user')->first();
		if(Sentry::check())
		{
			$user = Sentry::getUser();
			return View::make('viewReview')->withReview($review)->withUser($user);
		}
		else
		{
			return View::make('viewReview')->withReview($review);	
		}		
	}

	public function addPhoto($id){

		if(Input::hasFile('photo'))
		{
			$photo = new Business_photo;
			$image = Input::file('photo');
	        $filename = strtotime('now').$image->getClientOriginalName();
	        $image->move('uploads', $filename);
	        $photo->picture = $filename;
	        $photo->title = htmlentities(Input::get('caption'));
	        $photo->business_id = $id;
	        $photo->user_id = Sentry::getUser()->id;
	        $photo->save();

	        $activity = new Activity;
	        $activity->user_id = Sentry::getUser()->id;
	        $activity->action = "add_photo";
	        $activity->reference_id = $photo->id;
	        $activity->save();

	        return Redirect::route('viewBusiness',array('id'=>$id));

		}
		else
		{
			App::abort(404);
		}
	}

	public function deletePhoto($id)
	{
		$user = Sentry::getUser();
		$photo = Business_photo::find($id);
		$admin = Sentry::findGroupByName('admin');
	  	if($user->inGroup($admin))
	  	{
	  		$photo->delete();
	  	}
	  	else
	  	{
	  		if($photo->user_id==$user->id)
	  		{
	  			$photo->delete();
	  		}
	  		else
	  		{
	  			return Redirect::route('viewBusinessGallery',array('id'=>$photo->business_id))->withError('You can\'t delete this photo');
	  		}
	  	}

	  	Activity::where('reference_id',$id)->where('action','add_photo')->delete();

	  	return Redirect::route('viewBusinessGallery',array('id'=>$photo->business_id))->withSuccess('Photo is deleted successfully');

	}

	public function successPayment($id){

		$business_id = $id;
		$gateway = Omnipay::create('PayPal_Express');
	      $gateway->setUsername(Config::get('paypal.username'));
	      $gateway->setPassword(Config::get('paypal.password'));
	      $gateway->setSignature(Config::get('paypal.signature'));
	      $gateway->setTestMode(Config::get('paypal.testmode'));

			$response = $gateway->completePurchase(
			                    array(
			                        'cancelUrl' => URL::route('failedPayment'),
			                        'returnUrl' => URL::route('successPayment'), 
			                        'amount' => (double)Config::get('settings.featuredAdCost'),
			                        'currency' => 'USD'
			                    )
			            )->send();		


			if ( ! $response->isSuccessful())
      		{
				return Redirect::route('viewBusiness',array('id'=>$business->id))->withError('Transaction is failed');      			
      		}
      		else
      		{

      			$business = Business::find($business_id);

      			if($business->featured_ad_expiry=='0000-00-00')
      			{
      				$NewDate=Date('Y-m-d', strtotime("+30 days"));
      				$business->featured_ad_expiry = $NewDate;
      			}
      			else
      			{
      				$today = new DateTime('');
					$expire = new DateTime($business->featured_ad_expiry);

					if($today->format("Y-m-d") > $expire->format("Y-m-d")) { 
					  	$NewDate=Date('Y-m-d', strtotime("+30 days"));
      					$business->featured_ad_expiry = $NewDate;
					}
					else
					{
						$expiryDate = $expire->format('Y-m-d');
						$NewDate = Date('Y-m-d', strtotime($expiryDate."+30 day"));
						$business->featured_ad_expiry = $NewDate;
					}
      			}

      			$transaction = new Transaction;

      			$transaction->user_id = Sentry::getUser()->id;
      			$transaction->business_id = $business_id;
      			$transaction->amount = Config::get('settings.featuredAdCost');
      			$transaction->save();

      			$business->save();
      			Session::forget('business');
      			return Redirect::route('viewBusiness',array('id'=>$business->id))->withSuccess('Now your business will be featured till '.$business->featured_ad_expiry);
      		}
	}

	public function upgrade($id)
	{

		$gateway = Omnipay::create('PayPal_Express');
		$gateway->setUsername(Config::get('paypal.username'));
      $gateway->setPassword(Config::get('paypal.password'));
      $gateway->setSignature(Config::get('paypal.signature'));
      $gateway->setTestMode(Config::get('paypal.testmode'));

		$response = $gateway->purchase(
		                    array(
		                        'cancelUrl' => URL::route('failedPayment'),
		                        'returnUrl' => URL::route('successPayment',array('id'=>$id)), 
		                        'amount' => (double)Config::get('settings.featuredAdCost'),
		                        'currency' => 'USD',
		                        'description'	=> 'Featured business for $'.Config::get('settings.featuredAdCost').'/month'
		                    )
		            )->send();

		$response->redirect();
	}

	public function updateBusinessHours($id)
	{
		$business = Business::find($id);

		if($business->user_id == Sentry::getUser()->id)
		{
			$business->business_hours = Input::get('mon').'|'.Input::get('tue').'|'.Input::get('wed').'|'.Input::get('thu').'|'.Input::get('fri').'|'.Input::get('sat').'|'.Input::get('sun');
			$business->save();
			return Redirect::route('viewBusiness',array('id'=>$id))->withSuccess('Business Hours are updated successfully');
		}

		App::abort(404);
	}


	public function updateMoreInfo($id)
	{
		$business = Business::find($id);

		if($business->user_id == Sentry::getUser()->id)
		{
			$business->more_info = Input::get('moreInfo');
			$business->save();
			return Redirect::route('viewBusiness',array('id'=>$id))->withSuccess('Business Hours are updated successfully');
		}

		App::abort(404);
	}

}
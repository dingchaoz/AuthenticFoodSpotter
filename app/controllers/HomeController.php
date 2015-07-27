<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	function time_since($since) {
	    $chunks = array(
	        array(60 * 60 * 24 * 365 , 'year'),
	        array(60 * 60 * 24 * 30 , 'month'),
	        array(60 * 60 * 24 * 7, 'week'),
	        array(60 * 60 * 24 , 'day'),
	        array(60 * 60 , 'hour'),
	        array(60 , 'minute'),
	        array(1 , 'second')
	    );

	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        if (($count = floor($since / $seconds)) != 0) {
	            break;
	        }
	    }

	    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
	    return $print;
	}

	public function welcome()
	{

		if(Config::get('settings.reviewOfTheDay'))
		{
			$featuredReview = Review::where('id',Config::get('settings.reviewOfTheDay'))->with('user','business')->first();
		}
		else
		{
			$featuredReview = NULL;
		}
		if(Sentry::check())
		{
			$user = Sentry::getUser();
			$friendRequests = Friend::where('friend_id',$user->id)->where('status','pending')->with('user')->get();

			$user = User::where('id',$user->id)->with('friends','friendsWithMe')->first();
      
		      $friends = array();

		      foreach($user->friendsWithMe as $friend)
		      {
		        array_push($friends, $friend->user);
		      }

		      foreach($user->friends as $friend)
		      {
		        array_push($friends, $friend->friend);
		      }
			
			if(isset($_GET['by']))
			{
				if($_GET['by']=="friends")
				{
					$user = User::where('id',$user->id)->with('friends','friendsWithMe')->first();
      			
				      $friends = array();

				      foreach($user->friendsWithMe as $friend)
				      {
				      	if($friend->status=="accepted")
				        	array_push($friends, $friend->user_id);
				      }

				      foreach($user->friends as $friend)
				      {
				      	if($friend->status=="accepted")
				        	array_push($friends, $friend->friend_id);
				      }

				      if(count($friends))
				      	$activities = Activity::orderBy('updated_at','desc')->whereIn('user_id',$friends)->paginate(10);
				      else
				      	$activities = array();
				}
				elseif($_GET['by']=="following")
				{
					$following_users = Follow::where('follower_id',$user->id)->select('user_id')->get();
					if($following_users->count())
					{
						$followings = array();
						foreach($following_users as $following_user)
						{
							array_push($followings, $following_user->user_id);
						}
						$activities = Activity::orderBy('updated_at','desc')->whereIn('user_id',$followings)->paginate(10);	
					}
					else
					{
						$activities = array();
					}
					
				}
				elseif($_GET['by']=="me")
				{
					$activities = Activity::orderBy('updated_at','desc')->where('user_id',$user->id)->paginate(10);	
				}
			}
			else
			{
				$activities = Activity::orderBy('updated_at','desc')->paginate(10);	
			}
			

			$actions = array();
			foreach($activities as $activity)
			{
				if($activity->action == 'add_photo')
				{
					$action = Business_photo::where('id',$activity->reference_id)->with('business','user')->first(); 
				}
				elseif($activity->action == 'add_review' || $activity->action == 'update_review')
				{
					$action = Review::where('id',$activity->reference_id)->with('business','user')->first(); 
				}
				else
				{
					$action = null;
				}
				if($action!=null)
				{
					$action->time = $this->time_since(time() - strtotime($action->updated_at));
					$action->action = $activity->action;
				}
				array_push($actions, $action);
			}	

			$no_of_reviews = Review::where('user_id',$user->id)->count();

			return View::make('dashboard')->withUser($user)->withActions($actions)->with('friendRequests',$friendRequests)->withFriends($friends)->with('noOfReviews',$no_of_reviews)->with('featuredReview',$featuredReview);
		}
		else
		{
			$activities = Activity::orderBy('updated_at','desc')->paginate(10);

			$actions = array();
			foreach($activities as $activity)
			{
				if($activity->action == 'add_photo')
				{
					$action = Business_photo::where('id',$activity->reference_id)->with('business','user')->first(); 
				}
				elseif($activity->action == 'add_review' || $activity->action == 'update_review')
				{
					$action = Review::where('id',$activity->reference_id)->with('business','user')->first(); 
				}
				else
				{
					$action = null;
				}
				if($action!=null)
				{
					$action->time = $this->time_since(time() - strtotime($action->updated_at));
					$action->action = $activity->action;
				}
				array_push($actions, $action);
			}	

			$categories = Category::with('businesses')->where('active','1')->take(10)->get();
			
			return View::make('welcome')->withUser('users')->withActions($actions)->with('featuredReview',$featuredReview)->withCategories($categories);
		}
		
	}

	public function viewBusiness($id)
	{
		$business = Business::where('id',$id)->with('city','state','country','user','category','sub_category','reviews','photos')->first();

		if($business->business_hours != NULL)
			$times = explode('|', $business->business_hours);
		else
			$times = NULL;

		if(Sentry::check())
		{
			$user = Sentry::getUser();
			$review = Review::where('user_id',$user->id)->where('business_id',$business->id)->first();
			return View::make('viewBusiness')->withUser($user)->withBusiness($business)->withReview($review)->withTimes($times);	
		}
		else
		{
			return View::make('viewBusiness')->withBusiness($business)->withTimes($times);	
		}
	}


	public function viewSearch(){
		if(isset($_GET['find'])&&isset($_GET['near']))
		{

			$today = new DateTime('');
			Business::where('featured_ad_expiry','<',$today->format('Y-m-d'))->update(array('featured_ad_expiry'=>'0000-00-00'));

			$near = $_GET['near'];
			$cities_data = City::where('label','LIKE','%'.$near.'%')->select('id')->get();
			$cities = array();
			foreach($cities_data as $city)
			{
				array_push($cities, $city->id); 
			}


			$countries_data = Country::where('label','LIKE','%'.$near.'%')->select('id')->get();
			$countries = array();
			foreach($countries_data as $city)
			{
				array_push($countries, $city->id); 
			}

			$states_data = State::where('label','LIKE','%'.$near.'%')->select('id')->get();
			$states = array();
			foreach($states_data as $city)
			{
				array_push($states, $city->id); 
			}

			$businesses = Business::with('city','state','country','user','category','sub_category','reviews','photos');

			

			if(count($cities))
			{
				$businesses = $businesses->whereIn('city_id',$cities);
			}

			if(count($countries))
			{
				$businesses = $businesses->whereIn('country_id',$countries);
			}

			if(count($states))
			{
				$businesses = $businesses->whereIn('state_id',$states);
			}

			if($_GET['find']!='')
				$businesses = $businesses->where('name','LIKE','%'.$_GET['find'].'%');

			if(count($cities) == 0 && count($countries) == 0 && count($states) == 0)
			{
				$businesses = Business::where('id',NULL)->orderBy('featured_ad_expiry','desc')->paginate(10);
			}
			else
			{
				$businesses = $businesses->orderBy('featured_ad_expiry','desc')->paginate(10);
			}

			return View::make('viewSearch')->withBusinesses($businesses);
		}
	}

	public function explore()
	{
		$countries = Country::with('states')->get();
		return View::make('explore')->withCountries($countries);
	}

	public function businessInState($id)
	{
		$state = State::where('id',$id)->with('country')->first();
		$today = new DateTime('');
		Business::where('featured_ad_expiry','<',$today->format('Y-m-d'))->update(array('featured_ad_expiry'=>'0000-00-00'));
		$businesses = Business::where('state_id',$id)->with('city','state','country','user','category','sub_category','reviews','photos')->orderBy('featured_ad_expiry','desc')->paginate(10);
		return View::make('businessInState')->withBusinesses($businesses)->withState($state);
	}

	public function viewBusinessBySubCategory($id)
	{
		$sub_category = Sub_category::where('id',$id)->first();
		$today = new DateTime('');
		Business::where('featured_ad_expiry','<',$today->format('Y-m-d'))->update(array('featured_ad_expiry'=>'0000-00-00'));
		$businesses = Business::where('sub_category_id',$id)->with('city','state','country','user','category','sub_category','reviews','photos')->orderBy('featured_ad_expiry','desc')->paginate(10);
		return View::make('viewBusinessBySubCategory')->withBusinesses($businesses)->with('sub_category',$sub_category);
	}

	public function viewBusinessByCategory($id)
	{
		$category = Category::where('id',$id)->first();
		$today = new DateTime('');
		Business::where('featured_ad_expiry','<',$today->format('Y-m-d'))->update(array('featured_ad_expiry'=>'0000-00-00'));
		$businesses = Business::where('category_id',$id)->with('city','state','country','user','category','sub_category','reviews','photos')->orderBy('featured_ad_expiry','desc')->paginate(10);
		return View::make('viewBusinessByCategory')->withBusinesses($businesses)->with('category',$category);
	}

	public function findFriends(){
		$user = Sentry::getUser();
		if(!isset($_GET['name']))
			$users = User::all();
		else
			$users = User::where('first_name','LIKE','%'.$_GET['name'].'%')->orWhere('last_name','LIKE','%'.$_GET['name'].'%')->get();

		return View::make('findFriends')->withUsers($users)->withUser($user);
	}

	public function vanityUrlRedirection($username)
	{
		$user = User::where('username',$username)->first();

		return Redirect::route('viewPublicProfile',array('as'=>$user->id));
	}

	public function viewPage($id)
	{
		$page = Static_page::find($id);
		return View::make('viewPage')->withPage($page);
	}
	
}

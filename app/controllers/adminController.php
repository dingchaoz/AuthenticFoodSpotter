<?php

class AdminController extends \BaseController {


	public function dashboard()
	{
		$user = Sentry::getUser();
    $statistics = array();
    $statistics['users'] = User::count();
    $statistics['businesses'] = Business::count();
    $statistics['reviews'] = Review::count();
    $statistics['revenue'] = Transaction::sum('amount');
		return View::make('admin.dashboard')->withUser($user)->withStatistics($statistics);
	}

	public function install()
	{
		$setting1 = new Setting;
		$setting1->option = "title";
		$setting1->value = Input::get('title');
		$setting1->save();

    $setting2 = new Setting;
    $setting2->option = "keywords";
    $setting2->value = Input::get('keywords');
    $setting2->save();

    $setting3 = new Setting;
    $setting3->option = "footer";
    $setting3->value = Input::get('footer');
    $setting3->save();

    $setting4 = new Setting;
    $setting4->option = "email";
    $setting4->value = Input::get('email');
    $setting4->save();

    $setting5 = new Setting;
    $setting5->option = "banner1";
    $setting5->value = "";
    $setting5->save();

		try
      {
        
        // Create the user
        $user = Sentry::createUser(array(
                                     'email'      => Input::get('email'),
                                     'password'   => Input::get('password'),
                                     'username'   => "admin",
                                     'activated'  => true
                                   ));

        // Find the group using the group name
        $userGroup = Sentry::findGroupByName('admin');

        // Assign the group to the user
        $user->addGroup($userGroup);

        Sentry::login($user,true);

        return Redirect::route('adminDashboard')->with('success','Your site is installed successfully');

      }
      catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
      {
        return Redirect::route('install')->withInput(Input::except('password'))->with('error', 'Login Field is Required');
      }
      catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
      {
        return Redirect::route('install')->withInput()->with('error', 'Password Field is Required');
      }
      catch (Cartalyst\Sentry\Users\UserExistsException $e)
      {
        return Redirect::route('install')->withInput(Input::except('password'))->with('error', 'User Already Exists');
      }
      catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
      {
        return Redirect::route('install')->withInput(Input::except('password'))->with('error', 'Group Not Found');
      }

	}

	public function userManagement(){
		$group = Sentry::findGroupByName('users');

      $users = Sentry::findAllUsersInGroup($group);

      $user = Sentry::getUser();

      return View::make('admin.userManagement')->withUsers($users)->withUser($user);
	}


  public function userDelete($id)
    {
      try
      {
          // Find the user using the user id
          $user = Sentry::findUserById($id);

          Activity::where('user_id',$id)->delete();
          Review::where('user_id',$id)->delete();
          Friend::where('user_id',$id)->orWhere('friend_id',$id)->delete();
          Claim_request::where('user_id',$id)->delete();
          Follow::where('user_id',$id)->orWhere('follower_id',$id)->delete();
          Edit_log::where('user_id',$id)->delete();
          
          // Delete the user
          $user->delete();

          return Redirect::route('adminUserManagement')->withSuccess('User is deleted successfully');
      }
      catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
          return Redirect::route('adminUserManagement')->withError('User was not found.');
      }

    }

  public function userSuspend($id)
  {
    try
    {
        $throttle = Sentry::findThrottlerByUserId($id);

        if($suspended = $throttle->isSuspended())
        {
          return Redirect::route('adminUserManagement')->withError('This user is already suspended for '.$throttle->getSuspensionTime().' minutes.');
        }
        else
        {
          $throttle->suspend();
          return Redirect::route('adminUserManagement')->withSuccess('User has been suspended successfully.');
        }
        
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
    {
        return Redirect::route('adminUserManagement')->withError('User was not found.');
    }

  }

  public function userBan($id)
  {
    try
    {
        $throttle = Sentry::findThrottlerByUserId($id);

        if($suspended = $throttle->isBanned())
        {
          return Redirect::route('adminUserManagement')->withError('This user is already banned.');
        }
        else
        {
          $throttle->ban();

          return Redirect::route('adminUserManagement')->withSuccess('User has been banned Successfully :)');

        }
        
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
    {
        return Redirect::route('adminUserManagement')->withError('User was not found.');
    }

  }

  public function userUnsuspend($id)
  {
    try
    {
        $throttle = Sentry::findThrottlerByUserId($id);

        if($suspended = $throttle->isSuspended())
        {
          $throttle->unsuspend();
          return Redirect::route('adminUserManagement')->withSuccess('This user is unsuspended successfully');
        }
        else
        {
          return Redirect::route('adminUserManagement')->withError('This user is not suspended before');
        }
        
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
    {
        return Redirect::route('adminUserManagement')->withError('User was not found.');
    }

  }

  public function userUnban($id)
  {
    try
    {
        $throttle = Sentry::findThrottlerByUserId($id);

        if($suspended = $throttle->isBanned())
        {
          $throttle->unban();
          return Redirect::route('adminUserManagement')->withSuccess('This user is unbanned successfully :)');
        }
        else
        {
          return Redirect::route('adminUserManagement')->withError('This user is not banned :(');

        }
        
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
    {
        return Redirect::route('adminUserManagement')->withError('User was not found.');
    }

  }

  public function categoryManagement(){

    $categories = Category::all();

    $user = Sentry::getUser();

    return View::make('admin.categoryManagement')->withCategories($categories)->withUser($user);
  }

  public function addCategory(){

    $category = new Category;

    $category->category_name = Input::get('category');
    $category->active = 1;

    $category->save();

    return Redirect::route('adminCategoryManagement')->withSuccess('Category added successfully');
  }

  public function enableCategory($id){
    $category = Category::find($id);
    $category->active = 1;
    $category->update();

    return Redirect::route('adminCategoryManagement')->withSuccess('Category enabled successfully');
  }

  public function disableCategory($id){
    $category = Category::find($id);
    $category->active = 0;
    $category->update();

    return Redirect::route('adminCategoryManagement')->withSuccess('Category disabled successfully');
  }

  public function categoryView($id){

    $category = Category::find($id);

    $sub_categories = $category->sub_categories()->get();

    $user = Sentry::getUser();

    return View::make('admin.categoryView')->withCategory($category)->with('sub_categories',$sub_categories)->withUser($user);

  }

  public function addSubCategory($id){
    
    $sub_category = new Sub_category;

    $sub_category->active = 1;
    $sub_category->sub_category = Input::get('sub_category');
    $sub_category->category_id = $id;

    $sub_category->save();

    return Redirect::route('adminCategoryView',array('id' => $id))->withSuccess('Sub Category added successfully');
  }

  public function enableSubCategory($id){
    $sub_category = Sub_category::find($id);
    $sub_category->active = 1;
    $sub_category->update();

    $id = $sub_category->category->id;

    return Redirect::route('adminCategoryView',array('id' => $id))->withSuccess('Sub Category enabled successfully');
  }

  public function disableSubCategory($id){
    $sub_category = Sub_category::find($id);
    $sub_category->active = 0;
    $sub_category->update();

    $id = $sub_category->category->id;

    return Redirect::route('adminCategoryView',array('id' => $id))->withSuccess('Sub Category disabled successfully');
  }

  public function settings(){
    $user = Sentry::getUser();
    return View::make('admin.settings')->withUser($user);
  }

  public function updateSettings(){
    $setting = Setting::where('option','title')->update(array('value' => Input::get('title')));

    $setting = Setting::where('option','keywords')->update(array('value' => Input::get('keywords')));

    $setting = Setting::where('option','footer')->update(array('value' => Input::get('footer')));

    $setting = Setting::where('option','email')->update(array('value' => Input::get('email')));

    return Redirect::route('adminSettings')->withSuccess('You Settings updated successfully');
  }

  public function questionManagement(){
    $questions = Question::all();
    $user = Sentry::getUser();
    return View::make('admin.questionManagement')->withQuestions($questions)->withUser($user);
  }

  public function addQuestion(){
    $question = new Question;
    $question->question = Input::get('question');
    $question->text = Input::get('text');
    $question->active = 1;
    $question->save();

    return Redirect::route('adminQuestionManagement')->withSuccess('Question Added successfully');
  }

  public function questionView($id){
    $question = Question::find($id);
    $user = Sentry::getUser();
    return View::make('admin.questionView')->withQuestion($question)->withUser($user);
  }




  public function questionUpdate($id){
    $question = Question::find($id);
    $question->question = Input::get('question');
    $question->text = Input::get('text');
    $question->save();

    return Redirect::route('adminQuestionView',array('id'=>$id))->withSuccess('Question updated successfully');
  }

  public function enableQuestion($id){
    $question = Question::find($id);
    $question->active = 1;
    $question->update();

    return Redirect::route('adminQuestionManagement')->withSuccess('Question enabled successfully');
  }

  public function disableQuestion($id){
    $question = Question::find($id);
    $question->active = 0;
    $question->update();

    return Redirect::route('adminQuestionManagement')->withSuccess('Question disabled successfully');
  }

  public function editManagement(){
    $user = Sentry::getUser();
    $edit_logs = Edit_log::where('status',NULL)->get();

    //print_r($edit_logs);
    return View::make('admin.editManagement')->withEdit_logs($edit_logs)->withUser($user);
  }
  
  public function viewEdit($id){
    $user = Sentry::getUser();
    $edit_log = Edit_log::find($id);

    if($edit_log->status == NULL)
    {
      $business = Business::with('city','state','country','user','category','sub_category')->where('id',$edit_log->business_id)->first();
      $edit_log = json_decode($edit_log->edits);
      return View::make('admin.viewEdit')->withUser($user)->withEdit_log($edit_log)->withBusiness($business)->withId($id);
    }
  }

  public function approveEdit($id){
    $edit_log = Edit_log::find($id);

    if($edit_log->status == NULL)
    {
      $data = json_decode($edit_log->edits);


      if(isset($data->name))
      {
        $business = Business::find($edit_log->business_id);
        $business->name = $data->name;
        $business->street_no = $data->street_no;
        $business->street_name = $data->street_name;

         $country = Country::firstOrCreate(array('label' => $data->country));
        $business->country_id = $country->id;

        $state = State::firstOrCreate(array('label' => $data->state,'country_id' => $country->id));
        $business->state_id = $state->id;

        $city = City::firstOrCreate(array('label'=>$data->city,'state_id'=>$state->id,'country_id'=>$country->id));
        $business->city_id = $city->id;
        
        
        $business->zipcode = $data->zipcode;
        $business->lat  = $data->lat;
        $business->lon  = $data->lon;
        $business->phone  = $data->phone;
        $business->website  = $data->website;
        $business->save();
        
      }

      $edit_log->status = 1;
      $edit_log->save();
      return Redirect::route('adminEditManagement')->withSuccess('Edit is approved successfully');
    }
  }

  public function rejectEdit($id)
  {
    $edit_log = Edit_log::find($id);
    $edit_log->status = 0;
    $edit_log->save();
    return Redirect::route('adminEditManagement')->withSuccess('Edit is rejected successfully');
  
  }

  public function reviewManagement()
  {
    $user = Sentry::getUser();
    $reviews = Review::with('business','user')->paginate(10);

    return View::make('admin.reviewManagement')->withReviews($reviews)->withUser($user);

  }

  public function deleteReview($id)
  {
    $current_review = Review::find($id);

    if(!isset($current_review->business))
    {
      $review = Review::find($id)->delete();
      return Redirect::route('adminReviewManagement')->withSuccess('Review Deleted Successfully');
    }

    $business = $current_review->business;
    
    if($business->no_of_ratings != 1){
        $business->rating = (($business->rating*$business->no_of_ratings)-$current_review->score)/($business->no_of_ratings-1);
        $business->no_of_ratings = $business->no_of_ratings-1;  
    }else{
      $business->rating = 0;
      $business->no_of_ratings = 0;
    }
      
      $business->save();

    $review = Review::find($id)->delete();
    return Redirect::route('adminReviewManagement')->withSuccess('Review Deleted Successfully');
  }

  public function featureReview($id)
  {
    $setting = Setting::where('option','reviewOfTheDay')->update(array('value' => $id));
    return Redirect::route('adminReviewManagement')->withSuccess('Review Featured Successfully');
  }

  public function deleteBusiness($id)
  {
    $business = Business::find($id)->delete();
    $reviews = Review::where('business_id',$id)->delete();
    return Redirect::route('businessManagement')->withSuccess('Business Deleted Successfully');
  }

  public function businessClaimRequests()
  {
    $claimRequests = Claim_request::where('approved',NULL)->with('user','business')->paginate(10);
    $user = Sentry::getUser();
    return View::make('admin.claimRequests')->with('claimRequests',$claimRequests)->withUser($user);
  }

  public function approveClaim($id)
  {
    $claimRequest = Claim_request::find($id);
    $claimRequest->approved = 1;

    $claimRequest->save();

    $business = Business::find($claimRequest->business->id);

    $business->user_id = $claimRequest->user->id;

    $business->save();

    return Redirect::route('adminBusinessClaimRequests')->withSuccess('Claim request is approved successfully');
  }

  public function rejectClaim($id)
  {
    $claimRequest = Claim_request::find($id);
    $claimRequest->approved = 0;
    $claimRequest->save();

    return Redirect::route('adminBusinessClaimRequests')->withSuccess('Claim request is rejected successfully');
  }

  public function businessManagement()
  {
    $user = Sentry::getUser();
    $businesses = Business::with('city','state','country','user','category','sub_category')->paginate(10);

    return View::make('admin.businessManagement')->withBusinesses($businesses)->withUser($user);
  }

  public function adsManagement(){
    $user = Sentry::getUser();
    $transactions = Transaction::with('user','business')->paginate(10);
    return View::make('admin.adsManagement')->withUser($user)->withTransactions($transactions);
  }

  public function updateAds(){
    $setting = Setting::where('option','banner1')->update(array('value' => Input::get('banner1')));

    $setting = Setting::where('option','featuredAdCost')->update(array('value' => Input::get('featuredAdCost')));

    return Redirect::route('adminAdsManagement')->withSuccess('Ads are updated successfully');
  }

  public function pagesManagement(){
    $pages = Static_page::all();
    $user = Sentry::getUser();
    return View::make('admin.pagesManagement')->withUser($user)->withPages($pages);
  }

  public function addPage(){
    $page = new Static_page;
    $page->label = Input::get('page_label');
    $page->save();

    return Redirect::route('adminPagesManagement')->withSuccess('Page added successfully');
  }

  public function deletePage($id){
    $page = Static_page::where('id',$id)->delete();

    return Redirect::route('adminPagesManagement')->withError('Page deleted successfully');
  }

  public function editPage($id){
    $user = Sentry::getUser();
    $page = Static_page::find($id);
    return View::make('admin.pageEdit')->withUser($user)->withPage($page);
  }

  public function updatePage($id)
  {
    $page = Static_page::find($id);
    $page->label = Input::get('label');
    $page->text = Input::get('text');
    $page->save();

    return Redirect::back()->withSuccess('Page is updated successfully');
  }

  public function userActivate($id)
  {
    $user = Sentry::find($id);
    $user->activated = 1;
    $user->save();

    return Redirect::back()->withSuccess('User is activated successfully');

  }
}

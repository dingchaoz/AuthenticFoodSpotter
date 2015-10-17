<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'dashboard', 'uses' => 'HomeController@welcome'));

Route::get('/login', array( 'as' => 'login',function(){
	return View::make('login');
}))->before('guest');

Route::post('login','userController@login')->before('guest');

Route::get('register',array('as'=> 'register',function(){
	return View::make('register');
}))->before('guest');

Route::post('register','userController@register')->before('guest');

Route::get('authenticate','userController@authenticate')->before('guest');

Route::get('/forgotPassword',array('as'=>'forgotPassword',function(){
	return View::make('forgotPassword');
}))->before('guest');

Route::post('/forgotPassword','userController@forgotPassword')->before('guest');

Route::get('/reset', function(){
	return View::make('reset');
})->before('guest');

Route::post('/reset',array('as'=>'resetPassword','uses' => 'userController@resetPassword'))->before('guest');

Route::get('oauth/facebook', array('as' => 'flogin', 'uses' => 'userController@facebookLogin'));

Route::get('account/settings',array('as' => 'accountSettings', 'uses' => 'userController@accountSettings'))->before('auth');

Route::get('profile/edit',array('as'=>'editProfile', 'uses' => 'userController@editProfile'))->before('auth');

Route::post('profile/edit',array('as' => 'updatedProfile', 'uses' => 'userController@updateProfile'))->before('auth');

Route::get('password/change',array('as' => 'changePassword', 'uses' => 'userController@changePassword'))->before('auth');

Route::post('password/change',array('as' => 'updatePassword', 'uses' => 'userController@updatePassword'))->before('auth');

Route::get('profile/vanityurl',array('as' => 'getVanityUrl','uses' => 'userController@getVanityUrl'))->before('auth');

Route::post('profile/vanityurl',array('as'=> 'updateUsername','uses' => 'userController@updateUsername'))->before('auth');

Route::get('business/new',array('as'=>'newBusiness','uses' => 'businessController@newBusiness'))->before('auth');

Route::post('business/add',array('as'=>'addBusiness','uses'=>'businessController@addBusiness'))->before('auth');

Route::get('getSubcategory/{id}',array('as'=>'getSubcategory','uses'=>'businessController@getSubcategory'))->before('auth');

/***********
 *	Admin Panel
 ***********/

Route::group(array('prefix' => 'admin', 'before' => 'admin'), function(){

	Route::get('/',array('as' => 'adminDashboard', 'uses' => 'adminController@dashboard'));

	Route::get('/user/management',array('as' => 'adminUserManagement','uses' => 'adminController@userManagement'));

	// Delete user

	Route::get('delete/{id}','adminController@userDelete');

	// Suspend user

	Route::get('suspend/{id}','adminController@userSuspend');

	// Ban user

	Route::get('ban/{id}','adminController@userBan');

	// UnSuspend user

	Route::get('unsuspend/{id}','adminController@userUnsuspend');

	// UnBan user

	Route::get('unban/{id}','adminController@userUnban');

	// Activate User

	Route::get('activate/{id}','adminController@userActivate');

	Route::get('category/management',array('as' => 'adminCategoryManagement', 'uses' => 'adminController@categoryManagement'));

	Route::post('category/add','adminController@addCategory');

	Route::get('category/enable/{id}','adminController@enableCategory');

	Route::get('category/disable/{id}','adminController@disableCategory');

	Route::get('category/view/{id}',array('as' => 'adminCategoryView','uses' => 'adminController@categoryView'));

	Route::post('sub_category/add/{id}','adminController@addSubCategory');

	Route::get('sub_category/enable/{id}','adminController@enableSubCategory');

	Route::get('sub_category/disable/{id}','adminController@disableSubCategory');

	Route::get('settings',array('as' => 'adminSettings', 'uses' => 'adminController@settings'));

	Route::post('settings',array('as' => 'updateSettings', 'uses' => 'adminController@updateSettings'));

	Route::get('question/management', array('as'=>'adminQuestionManagement','uses'=>'adminController@questionManagement'));

	Route::post('question/add', array('as'=>'adminAddQuestion','uses'=>'adminController@addQuestion'));

	Route::get('question/view/{id}',array('as'=>'adminQuestionView','uses' => 'adminController@questionView'));

	Route::post('question/update/{id}',array('as'=>'adminQuestionUpdate','uses' => 'adminController@questionUpdate'));

	Route::get('business',array('as'=>'businessManagement','uses' => 'adminController@businessManagement'));

	Route::get('question/enable/{id}','adminController@enableQuestion');

	Route::get('question/disable/{id}','adminController@disableQuestion');

	Route::get('edit/management', array('as'=>'adminEditManagement','uses'=>'adminController@editManagement'));

	Route::get('edit/{id}',array('as'=>'adminViewEdit','uses'=>'adminController@viewEdit'));

	Route::get('edit/approve/{id}',array('as'=>'adminApproveEdit','uses'=>'adminController@approveEdit'));

	Route::get('edit/reject/{id}',array('as'=>'adminRejectEdit','uses'=>'adminController@rejectEdit'));

	Route::get('review/management', array('as'=>'adminReviewManagement','uses'=>'adminController@reviewManagement'));

	Route::get('review/{id}/delete',array('as'=>'deleteReview','uses'=>'adminController@deleteReview'));

	Route::get('review/{id}/feature',array('as'=>'featureReview','uses'=>'adminController@featureReview'));

	Route::get('business/{id}/delete',array('as'=>'deleteBusiness','uses'=>'adminController@deleteBusiness'));

	Route::get('claim/management',array('as'=>'adminBusinessClaimRequests','uses'=>'adminController@businessClaimRequests'));

	Route::get('claim/{id}/approve',array('as'=>'approveClaim','uses'=>'adminController@approveClaim'));

	Route::get('claim/{id}/reject',array('as'=>'rejectClaim','uses'=>'adminController@rejectClaim'));

	Route::get('ads/management', array('as'=>'adminAdsManagement','uses'=>'adminController@adsManagement'));

	Route::post('ads/management/update',array('as'=>'updateAds','uses'=>'adminController@updateAds'));

	Route::get('pages/management',array('as'=>'adminPagesManagement','uses'=>'adminController@pagesManagement'));

	Route::post('page/add',array('as'=>'addPage','uses'=>'adminController@addPage'));

	Route::get('page/{id}/delete',array('as'=>'adminPageDelete','uses'=>'adminController@deletePage'));

	Route::get('page/{id}/edit',array('as'=>'adminPageEdit','uses'=>'adminController@editPage'));

	Route::post('page/{id}/update',array('as'=>'adminPageUpdate','uses'=>'adminController@updatePage'));

});

Route::get('admin/install',array('as' => 'install',function(){
	return View::make('admin.install');
}))->before('new_installation');

Route::post('admin/install','adminController@install');

Route::get('logout',array('as'=>'logout','uses'=>'userController@logout'));

Route::get('business/{id}',array('as'=>'viewBusiness','uses'=>function($id){
	$business = Business::find($id);
	Session::reflash();
	return Redirect::route('viewBusinessWithVanity',array('id'=>$id,'name'=>str_replace(' ', '-', $business->name)));
}));

Route::get('business/{id}/edit',array('as'=>'editBusiness','uses'=>'businessController@editBusiness'))->before('auth');

Route::post('business/{id}/addPhoto',array('as'=>'addBusinessPhoto','uses'=>'businessController@addPhoto'))->before('auth');

Route::get('business/{id}/gallery',array('as'=>'viewBusinessGallery','uses'=>'businessController@viewBusinessGallery'));

Route::post('business/{id}/edit',array('as'=>'updateBusinessRequest','uses'=>'businessController@updateBusinessRequest'))->before('auth');

Route::get('business/{id}/writeReview',array('as'=>'writeReview','uses'=>'businessController@writeReview'))->before('auth');

Route::post('business/{id}/writeReview',array('as'=>'addReview','uses'=>'businessController@addReview'))->before('auth');

Route::get('business/{id}/upgrade',array('as'=>'upgradeBusiness','uses'=>'businessController@upgrade'))->before('auth');

Route::get('business/{id}/claim',array('as'=>'claimRequest','uses'=>'businessController@claimRequest'))->before('auth');

Route::get('business/{id}/{name}',array('as'=>'viewBusinessWithVanity','uses'=>'HomeController@viewBusiness'));

Route::get('user/reviews',array('as'=>'viewReviews','uses'=>'userController@viewReviews'))->before('auth');

Route::get('user/profile',array('as'=>'viewProfile','uses'=>'userController@viewProfile'))->before('auth');

Route::get('user/friends',array('as'=>'viewFriends','uses'=>'userController@viewFriends'))->before('auth');

Route::get('user/followers',array('as'=>'viewFollowers','uses'=>'userController@viewFollowers'))->before('auth');

Route::get('review/{id}',array('as'=>'viewReview','uses'=>'businessController@viewReview'));

Route::get('user/{id}',array('as'=>'viewPublicProfile','uses'=>'userController@viewPublicProfile'));

Route::get('user/{id}/addAsFriend',array('as'=>'addAsFriend','uses'=>'userController@addAsFriend'))->before('auth');

Route::get('user/{id}/confirmFriendRequest',array('as'=>'confirmFriendRequest','uses'=>'userController@confirmFriendRequest'))->before('auth');

Route::get('user/{id}/cancelFriendRequest',array('as'=>'cancelFriendRequest','uses'=>'userController@cancelFriendRequest'))->before('auth');

Route::get('messages',array('as'=>'viewMessages','uses'=>'userController@viewMessages'))->before('auth');

Route::get('user/{id}/friends',array('as'=>'viewFriendsInPublicProfile','uses'=>'userController@viewFriendsInPublicProfile'));

Route::get('user/{id}/followers',array('as'=>'viewFollowersInPublicProfile','uses'=>'userController@viewFollowersInPublicProfile'));

Route::get('user/{id}/follow',array('as'=>'follow','uses'=>'userController@follow'))->before('auth');

Route::get('user/{id}/unfollow',array('as'=>'unfollow','uses'=>'userController@unfollow'))->before('auth');

Route::get('photo/{id}/delete',array('as'=>'deletePhoto','uses'=>'businessController@deletePhoto'))->before('auth');

Route::post('messages/send',array('as'=>'sendMessage','uses'=>'userController@sendMessage'))->before('auth');

Route::get('conversation/{id}',array('as'=>'viewConversation','uses'=>'userController@viewConversation'))->before('auth');

Route::post('conversation/{id}/reply',array('as'=>'replyToConversation','uses'=>'userController@replyToConversation'))->before('auth');

Route::get('search',array('as'=>'viewSearch','uses'=>'HomeController@viewSearch'));

Route::get('explore',array('as'=>'explore','uses'=>'HomeController@explore'));

Route::get('find/friends',array('as'=>'findFriends','uses'=>'HomeController@findFriends'))->before('auth');

Route::get('explore/state/{id}',array('as'=>'viewBusinessInState','uses'=>'HomeController@businessInState'));

Route::get('sub_category/{id}',array('as' => 'viewBusinessBySubCategory','uses'=>'HomeController@viewBusinessBySubCategory'));

Route::get('category/{id}',array('as' => 'viewBusinessByCategory','uses'=>'HomeController@viewBusinessByCategory'));

Route::get('/featuredAd/payment/success/{id}',array('as'=>'successPayment','uses'=>'BusinessController@successPayment'))->before('auth');

Route::get('/featuredAd/payment/failed',array('as'=>'failedPayment','uses'=>'BusinessController@failedPayment'))->before('auth');

Route::get('/page/{id}',array('as'=>'viewPage','uses'=>'HomeController@viewPage'));

Route::post('/business/{id}/updateBusinessHours',array('as'=>'updateBusinessHours','uses'=>'BusinessController@updateBusinessHours'));

Route::post('/business/{id}/updateMoreInfo',array('as'=>'updateMoreInfo','uses'=>'BusinessController@updateMoreInfo'));

Route::get('/{username}','HomeController@vanityUrlRedirection');
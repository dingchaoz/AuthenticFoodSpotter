<?php
  use Facebook\FacebookSession;
  use Facebook\FacebookRequest;
  use Facebook\GraphUser;
  use Facebook\FacebookRequestException;


class UserController extends \BaseController {



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

	public function logout(){
      Sentry::logout();
      return Redirect::route('login')->with('success','Logged out successfully');
    }

    public function login()
    {
      try
      {

        $rules = array('email' => 'required|email',
                       'password' => 'required'
                       );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
          return Redirect::route('login')->withErrors($validator);
        }

        $credentials = array(
          'email'    => htmlentities($_POST['email']),
          'password' => htmlentities($_POST['password']),
        );

        $user = Sentry::authenticate($credentials, false);
      }
      catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
      {
        return Redirect::route('login')->withInput(Input::except('password'))->with('error', 'Login Field is Required');
      }
      catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
      {
        return Redirect::route('login')->withInput(Input::except('password'))->with('error', 'Password Field is Required');
      }
      catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
      {
        return Redirect::route('login')->withInput(Input::except('password'))->with('error', 'Wrong password, try again.');
      }
      catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
        return Redirect::route('login')->withInput(Input::except('password'))->with('error', 'User was not found.');
      }
      catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
      {
        return Redirect::route('login')->withInput(Input::except('password'))->with('error', 'User is not activated.');
      }
      catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
      {
        return Redirect::route('login')->withInput(Input::except('password'))->with('error', 'User is suspended.');
      }
      catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
      {
        return Redirect::route('login')->withInput(Input::except('password'))->with('error', 'User is banned.');
      }


      $admin = Sentry::findGroupByName('admin');

      if(!$user->inGroup($admin))
      {
        return Redirect::route('dashboard')->with('success', 'Login Successful');
      }
      else
      {
        return Redirect::route('adminDashboard')->with('success', 'Login Successful');
      }

  }

  public function register(){
        
      try
      {
        $rules = array('email' => 'required|email',
                       'password' => 'required',
                       );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
          return Redirect::route('register')->withErrors($validator);
        }
        
        // Create the user
        $user = Sentry::createUser(array(
                                     'email'      => Input::get('email'),
                                     'password'   => Input::get('password'),
                                     'first_name' => Input::get('first_name'),
                                     'last_name'  => Input::get('last_name')
                                   ));

        // Find the group using the group name
        $userGroup = Sentry::findGroupByName('users');

        // Assign the group to the user
        $user->addGroup($userGroup);

        $activationCode = $user->getActivationCode();

        $activationLink = URL::to('authenticate')."?email=".$_POST['email']."&code=".$activationCode;

        // $payload = array(
        //     'message' => array(
        //         'subject' => 'Activation mail',
        //         'html' => '<a href="'.$activationLink.'"> Click here to activate </a>',
        //         'from_email' => 'sriramancse@gmail.com',
        //         'to' => array(array('email'=>$_POST['email']))
        //     )
        // );

        // $response = Mandrill::request('messages/send', $payload);

        Mail::send('emails.activate', array('activationLink' => $activationLink), function($message)
        {
            $message->to($_POST['email'], '')->subject('Activation Mail');
        });

        return Redirect::route('register')->with('success','Check your mail for verification link. (including Spam folder) ');

      }
      catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
      {
        return Redirect::route('register')->withInput(Input::except('password'))->with('error', 'Login Field is Required');
      }
      catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
      {
        return Redirect::route('register')->withInput()->with('error', 'Password Field is Required');
      }
      catch (Cartalyst\Sentry\Users\UserExistsException $e)
      {
        return Redirect::route('register')->withInput(Input::except('password'))->with('error', 'User Already Exists');
      }
      catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
      {
        return Redirect::route('register')->withInput(Input::except('password'))->with('error', 'Group Not Found');
      }

    }

  public function authenticate()
  {
    try
    {
      $user = Sentry::findUserByLogin($_GET['email']);  
    }
    catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
    {
      Session::flash('error','User Not Found');
    }

    try
    {

      if ($user->attemptActivation($_GET['code']))
      {
          return Redirect::route('login')->with('success','Your account has been activated Successfully. Login now...');
      }
      else
      {
          return Redirect::to('login')->with('flash_error','Activation failed :(');
      }
    }
    catch(Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
    {
      Session::flash('error','You already activated your Account');
    }

    return Redirect::route('login');
  }

  public function forgotPassword(){

      $rules = array('email' => 'required|email'
                     );
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails())
      {
        return Redirect::route('forgotPassword')->withErrors($validator);
      }

      try
      {
        // Find the user using the user email address
        $user = Sentry::findUserByLogin($_POST['email']);

        // Get the password reset code
        $resetCode = $user->getResetPasswordCode();

        // Now you can send this code to your user via email for example.
        $resetLink = URL::to('reset')."?email=".$_POST['email']."&code=".$resetCode;

        // $payload = array(
        //     'message' => array(
        //         'subject' => 'Reset Password',
        //         'html' => '<a href="'.$resetLink.'"> Click here to reset </a>',
        //         'from_email' => 'sriramancse@gmail.com',
        //         'to' => array(array('email'=>$_POST['email']))
        //     )
        // );

        // $response = Mandrill::request('messages/send', $payload);

        Mail::send('emails.reset', array('resetLink'=>$resetLink), function($message)
        {
            $message->to($_POST['email'], '')->subject('Reset Your Password');
        });

        return Redirect::route('resetPassword')->with('success','Reset code sent to '.$_POST['email']); 

      }
      catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
          return Redirect::route('forgotPassword')->with('error','Your email is not a registered email id');
      }
    }

    public function resetPassword()
    {
      try
      {

        $rules = array('email' => 'required|email',
                       'code'  => 'required',
                       'password' => 'required|confirmed'
                      );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
          return Redirect::route('resetPassword')->withErrors($validator);
        }

        // Find the user using the user email
        $user = Sentry::findUserByLogin($_POST['email']);

        // Check if the reset password code is valid
        if ($user->checkResetPasswordCode($_POST['code']))
        {
          // Attempt to reset the user password
          if ($user->attemptResetPassword($_POST['code'],$_POST['password']))
          {
              return Redirect::route('login')->with('success','Your password is resetted successfully');
          }
          else
          {
              return Redirect::route('forgotPassword')->with('error','Resetting password failed.');
          }
        }
        else
        {
          return Redirect::route('forgotPassword')->with('error','Reset code provided is invalid.');
        }
      }
      catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
          Sesssion::put('error','User Not Available');
      }

    }


    public function facebookLogin(){
      $code = Input::get( 'code' );

      $fb = OAuth::consumer( 'Facebook' );

      if ( !empty( $code ) ) {
        $token = $fb->requestAccessToken( $code );

        $result = json_decode( $fb->request( '/me' ), true );

        return View::make('register')->withResult($result);

      }

      $url = $fb->getAuthorizationUri();

      return Redirect::to( (string)$url );
    }


    public function accountSettings(){

      $user = Sentry::getUser();

      return View::make('accountSettings')->withUser($user);

    }

    public function editProfile(){
      $user = Sentry::getUser();
      $questions = Question::where('active',1)->get();
      $allAnswers = Answer::where('user_id',$user->id)->get();
      $answers = array();
      foreach($allAnswers as $answer)
      {
        $answers[$answer->question_id] = $answer->answer;
      }
      return View::make('editProfile')->withUser($user)->withQuestions($questions)->withAnswers($answers);
    }

    public function updateProfile(){
      $user = Sentry::getUser();


      if(Input::get('first_name'))
      {
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');

        $user->update();  

        Answer::where('user_id',$user->id)->delete();

        $questions = Question::where('active',1)->get();

        foreach($questions as $question)
        {
          if(Input::has('question'.$question->id))
          {
            $answer = new Answer;
            $answer->user_id = $user->id;
            $answer->question_id = $question->id;
            $answer->answer = Input::get('question'.$question->id);
            $answer->save();
          }
        }
        return Redirect::route('editProfile')->withSuccess('Profile Updated successfully');
      }

      if(Input::hasFile('profile_picture'))
      {
        $image = Input::file('profile_picture');
        $filename = strtotime('now').$image->getClientOriginalName();
        $image->move('uploads', $filename);
        $user->picture = $filename;

        $user->update();

       return Redirect::route('editProfile')->withSuccess('Profile Picture Updated successfully'); 
      }
    }

    public function changePassword(){
      $user = Sentry::getUser();
      return View::make('changePassword')->withUser($user);
    }

    public function updatePassword(){

      $user = Sentry::getUser();

      try
      {
          // Login credentials
          $credentials = array(
              'email'    => $user->email,
              'password' => Input::get('current_password'),
          );

          // Authenticate the user
          $user = Sentry::authenticate($credentials, false);
      }
      catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
      {
          return Redirect::route('changePassword')->withError('Login field is required.');
      }
      catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
      {
          return Redirect::route('changePassword')->withError('Password field is required.');
      }
      catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
      {
          return Redirect::route('changePassword')->withError('Wrong password, try again.');
      }
      catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
      {
          return Redirect::route('changePassword')->withError('User was not found.');
      }

      $user->password = Input::get('new_password');

      $user->update();

      return Redirect::route('accountSettings')->withSuccess('Password updated successfully');
    }

    public function getVanityUrl(){
      $user = Sentry::getUser();
      return View::make('getVanityUrl')->withUser($user);
    }

    public function updateUsername(){

      $user = User::where('username',Input::get('username'));
      if(!$user->count())
      {
        $user = Sentry::getUser();
        $user->username = Input::get('username');
        $user->update();
        return Redirect::route('getVanityUrl')->withSuccess('Your vanity URL is updated successfully');
      }

      return Redirect::route('getVanityUrl')->withError('This Vanity URL is taken');
      
    }

    public function viewReviews(){
      $user = Sentry::getUser();
      $user = User::where('id',$user->id)->with('reviews','friends','friendsWithMe')->first();
      $friends = array();

      foreach($user->friendsWithMe as $friend)
      {
        array_push($friends, $friend->user);
      }

      foreach($user->friends as $friend)
      {
        array_push($friends, $friend->friend);
      }

      return View::make('viewReviews')->withUser($user)->withFriends($friends);
    }

    public function viewPublicProfile($id)
    {
      $user = User::where('id',$id)->with('friends','friendsWithMe')->first();

      $friends = array();

      foreach($user->friendsWithMe as $friend)
      {
        if($friend->status=="accepted")
          array_push($friends, $friend->user);
      }

      foreach($user->friends as $friend)
      {
        if($friend->status=="accepted")
          array_push($friends, $friend->friend);
      }


      if(Sentry::check())
      {
        $current_user = Sentry::getUser();

        $friend1 = Friend::where('user_id',$user->id)->where('friend_id',$current_user->id)->get();
	$friend2 = Friend::where('friend_id',$user->id)->where('user_id',$current_user->id)->get();
	$friend = $friend1->merge($friend2)->first();

if(isset($friend->status))
        {
          if($friend->status=="pending")
          {
            if($friend->user_id==$current_user->id)
            {
              $user->status = "requestSent";
            }
            else
            {
              $user->status = "confirmRequest";
            }
          }
          else
          {
            $user->status = $friend->status;
          }
          
        }

        $follower = Follow::where('user_id',$user->id)->where('follower_id',$current_user->id)->first();
        if($follower)
        {
          $user->follower = 1;
        }
        else
        {
          $user->follower = 0;
        }

      }

      $reviews = Review::where('user_id',$user->id)->paginate(10);

      // $friends_list = $user->friends->toArray() + $user->friendsWithMe->toArray();
      return View::Make('viewPublicProfile')->withUser($user)->withFriends($friends)->withReviews($reviews);
    }

    public function addAsFriend($id)
    {
      $friend = new Friend;
      $friend->user_id = Sentry::getUser()->id;
      $friend->friend_id = $id;
      $friend->status = "Pending";
      $friend->save();
      return Redirect::route('viewPublicProfile',array('id'=>$id))->withSuccess('Friend Request sent successfully');
    }

    public function confirmFriendRequest($id)
    {
      $current_user = Sentry::getUser();
      $friend = Friend::whereIn('user_id',array($current_user->id,$id))->whereIn('friend_id',array($current_user->id,$id))->first();
      $friend->status = "accepted";
      $friend->save();
      return Redirect::route('viewPublicProfile',array('id'=>$id))->withSuccess('Friend Request Accepted Successfully');
    }

    public function cancelFriendRequest($id)
    {
      $current_user = Sentry::getUser();
      $friend = Friend::whereIn('user_id',array($current_user->id,$id))->whereIn('friend_id',array($current_user->id,$id))->first();
      $friend->delete();
      return Redirect::route('dashboard')->withSuccess('Friend Request cancelled successfully');
    }

    public function viewMessages(){
      $user = Sentry::getUser();
      $conversations = Conversation::where('user1_id', '=', $user->id)
                ->orWhere('user2_id', '=', $user->id)->orderBy('updated_at','desc')->paginate(10);

      for($i=0;$i<$conversations->count();$i++)
      {
        if($conversations[$i]->user1_id == $user->id)
          $conversations[$i]->sender = User::find($conversations[$i]->user2_id);
        elseif($conversations[$i]->user2_id == $user->id)
          $conversations[$i]->sender = User::find($conversations[$i]->user1_id);

        $conversations[$i]->time_since = $this->time_since(time() - strtotime($conversations[$i]->updated_at)).' ago';
      }
      return View::Make('viewMessages')->withUser($user)->withConversations($conversations);
    }

    public function follow($id)
    {
      $current_user = Sentry::getUser();
      $follow = new Follow;
      $follow->user_id = $id;
      $follow->follower_id = $current_user->id;
      $follow->save();
    }

    public function unfollow($id)
    {
      $current_user = Sentry::getUser();
      Follow::where('user_id',$id)->where('follower_id',$current_user->id)->delete();
    }

    public function viewProfile()
    {
      $user = Sentry::getUser();
      $user = User::where('id',$user->id)->with('reviews','friends','friendsWithMe')->first();
            
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

      if($friends != array())
        $friends = User::whereIn('id',$friends)->get();

      return View::make('viewProfile')->withUser($user)->withFriends($friends);       
    }

    public function viewFriends()
    {
      $user = Sentry::getUser();
      $user = User::where('id',$user->id)->with('reviews','friends','friendsWithMe')->first();
      $friends = array();

      foreach($user->friendsWithMe as $friend)
      {
        array_push($friends, $friend->user);
      }

      foreach($user->friends as $friend)
      {
        array_push($friends, $friend->friend);
      }
      return View::make('viewFriends')->withUser($user)->withFriends($friends);       
    }

    public function viewFollowers()
    {
      $user = Sentry::getUser();
      $user = User::where('id',$user->id)->with('reviews','followers','friends','friendsWithMe')->first();
      $friends = array();

      foreach($user->friendsWithMe as $friend)
      {
        array_push($friends, $friend->user);
      }

      foreach($user->friends as $friend)
      {
        array_push($friends, $friend->friend);
      }
      return View::make('viewFollowers')->withUser($user)->withFriends($friends);       
    }

    public function sendMessage()
    {
      $sender = Sentry::getUser();
      $receiver = Input::get('to');
      $subject = Input::get('subject');
      $message_content = Input::get('message');

      if(!is_numeric($receiver))
      {
        $user = User::where('username',$receiver)->first();
        if(isset($user->id))
          $receiver = $user->id;
        else
          return Redirect::route('viewMessages')->withError('User is not found');
      }
      else
      {
        $user = User::where('id',$receiver)->first();
        if(isset($user->id))
          $receiver = $user->id;
        else
          return Redirect::route('viewMessages')->withError('User is not found');
      }

      $conversation = new Conversation;
      $conversation->user1_id = $receiver;
      $conversation->user2_id = $sender->id;
      $conversation->subject = $subject;
      $conversation->save();

      $message = new Message;
      $message->user_id = $sender->id;
      $message->conversation_id = $conversation->id;
      $message->message = $message_content;
      $message->save();

      return Redirect::route('viewConversation',array('id'=>$conversation->id))->withSuccess('Message Sent');
    
    }

    public function viewConversation($id)
    {

      $user = Sentry::getUser();
      $conversation = Conversation::where('id', $id)->first();

      if($conversation->user1_id!=$user->id && $conversation->user2_id!=$user->id)
      {
        App::abort(404);
      }

      $messages = Message::where('conversation_id',$id)->orderBy('created_at')->with('sender')->get();

      return View::make('viewConversation')->withConversation($conversation)->withMessages($messages);
    }

    public function replyToConversation($id)
    {
      $user = Sentry::getUser();
      $conversation = Conversation::where('id', $id)->first();

      if($conversation->user1_id!=$user->id && $conversation->user2_id!=$user->id)
      {
        App::abort(404);
      }

      $message = new Message;

      $message->user_id = $user->id;
      $message->message = Input::get('message');
      $message->conversation_id = $id;
      $message->save();

      $conversation->touch();

      return Redirect::route('viewConversation',array('id'=>$conversation->id))->withSuccess('Reply sent successfully');  
    }

}

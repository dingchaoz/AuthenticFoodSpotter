<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	public function business(){
		return $this->hasMany('Business');
	}

	public function reviews(){
		return $this->hasMany('Review')->with('Business');
	}

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function edit_log(){
		return $this->hasMany('Edit_log');
	}

	public function claim_request(){
		return $this->hasMany('Claim_request');
	}

	public function friends()
    {
       return $this->hasMany('Friend','user_id')->with('friend');
    }

    public function friendsWithMe()
    {
    	return $this->hasMany('Friend','friend_id')->with('user');
    }    

    public function followers()
    {
    	return $this->hasMany('Follow','user_id')->with('followers');
    }

    public function photos()
    {
    	return $this->hasMany('Business_photo')->with('user');
    }

    public function conversations()
    {
    	return $this->hasMany('Conversation');
    }
    public function transactions()
    {
    	return $this->hasMany('Transaction')->with('Business');
    }
}

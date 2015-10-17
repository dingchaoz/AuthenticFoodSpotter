<?php

class Business extends \Eloquent {
	protected $fillable = [];
	protected $table = 'businesses';
	public function city(){
		return $this->belongsTo('City');
	}
	public function state(){
		return $this->belongsTo('State');
	}
	public function country(){
		return $this->belongsTo('Country');
	}
	public function user(){
		return $this->belongsTo('User');
	}
	public function category(){
		return $this->belongsTo('Category');
	}
	public function sub_category(){
		return $this->belongsTo('Sub_category');
	}
	public function edit_log(){
		return $this->hasMany('Edit_log');
	}
	public function reviews(){
		return $this->hasMany('Review')->orderBy('updated_at','desc')->with('user');
	}
	public function claim_request(){
		return $this->hasMany('Claim_request');
	}
	public function photos()
    {
    	return $this->hasMany('Business_photo')->with('user');
    }
    public function transactions()
    {
    	return $this->hasMany('Transaction')->with('user');
    }
}
<?php

class State extends \Eloquent {
	protected $fillable = array('label','city_id','country_id');
	public function city(){
		return $this->hasMany('City');
	}
	public function country(){
		return $this->belongsTo('Country');
	}
	public function business(){
		return $this->hasMany('Business');
	}
}
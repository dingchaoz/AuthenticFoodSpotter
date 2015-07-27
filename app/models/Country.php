<?php

class Country extends \Eloquent {
	protected $fillable = array('label');
	protected $table = "countries";
	public function states(){
		return $this->hasMany('State');
	}
	public function cities(){
		return $this->hasMany('City');
	}
	public function businesses(){
		return $this->hasMany('Business');
	}
}
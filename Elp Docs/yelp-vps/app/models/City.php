<?php

class City extends \Eloquent {
	protected $fillable = array('country_id','label','state_id');
	protected $table = "cities";
	public function country(){
		return $this->belongsTo('Country');
	}
	public function state(){
		return $this->belongsTo('State');
	}
	public function business(){
		return $this->hasMany('Business');
	}
}
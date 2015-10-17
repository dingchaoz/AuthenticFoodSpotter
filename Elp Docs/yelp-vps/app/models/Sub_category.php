<?php

class Sub_category extends \Eloquent {

	protected $table = "sub_categories";
	protected $fillable = [];

	public function category(){
		return $this->belongsTo('Category');
	}
	public function business(){
		return $this->hasMany('Business');
	}
}
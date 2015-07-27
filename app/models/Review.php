<?php

class Review extends \Eloquent {
	protected $fillable = [];

	public function business(){
		return $this->belongsTo('Business')->with('category','sub_category');
	}

	public function user(){
		return $this->belongsTo('User')->with('reviews');
	}
}
<?php

class Claim_request extends \Eloquent {
	protected $fillable = [];

	public function business(){
		return $this->belongsTo('Business');
	}

	public function user(){
		return $this->belongsTo('User');
	}
}
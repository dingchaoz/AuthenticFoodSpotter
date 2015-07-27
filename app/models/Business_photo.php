<?php

class Business_photo extends \Eloquent {
	protected $fillable = [];

	public function business()
	{
		return $this->belongsTo('Business');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}
}
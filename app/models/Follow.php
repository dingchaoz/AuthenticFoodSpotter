<?php

class Follow extends \Eloquent {
	protected $fillable = [];

	public function user()
	{
		return $this->belongsTo('user','user_id');
	}

	public function followers()
	{
		return $this->belongsTo('user','follower_id');
	}
}
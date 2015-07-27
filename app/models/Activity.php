<?php

class Activity extends \Eloquent {
	protected $fillable = [];

	protected $table = "activities";

	public function user()
	{
		return $this->belongsTo('User','user_id');
	}
}
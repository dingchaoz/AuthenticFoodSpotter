<?php

class Friend extends \Eloquent {
	protected $fillable = [];

	public function user()
    {
        return $this->belongsTo('User','user_id');
    } 

    public function friend()
    {
    	return $this->belongsTo('User','friend_id');
    }

}
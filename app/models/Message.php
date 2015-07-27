<?php

class Message extends \Eloquent {
	protected $fillable = [];

	public function conversation(){
		return $this->belongsTo('Conversation');
	}

	public function sender(){
		return $this->belongsTo('User','user_id');
	}
}
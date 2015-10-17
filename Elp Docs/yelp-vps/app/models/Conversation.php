<?php

class Conversation extends \Eloquent {
	protected $fillable = [];

	public function messages(){
		return $this->hasMany('Message');
	}

	public function user1(){
		return $this->belongsTo('User','user1_id');
	}

	public function user2(){
		return $this->belongsTo('User','user2_id');
	}
}
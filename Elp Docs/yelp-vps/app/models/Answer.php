<?php

class Answer extends \Eloquent {
	protected $fillable = [];
	protected $table = 'answers';
	public function question(){
		return $this->belongsTo('Question');
	}

	public function user(){
		return $this->belongTo('User');
	}
}
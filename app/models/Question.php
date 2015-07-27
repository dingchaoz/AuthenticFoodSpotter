<?php

class Question extends \Eloquent {
	protected $fillable = [];
	protected $table = 'questions';
	public function answer(){
		return $this->hasMany('answer');
	}
	
}
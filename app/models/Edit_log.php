<?php

class Edit_log extends \Eloquent {
	protected $fillable = [];

	protected $table = 'edit_logs';

	public function business(){
		return $this->belongsTo('Business');
	}

	public function user(){
		return $this->belongsTo('User');
	}
}
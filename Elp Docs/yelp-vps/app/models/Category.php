<?php

class Category extends \Eloquent {

	protected $table = "categories";
	protected $fillable = [];

	public function sub_categories(){
		return $this->hasMany('Sub_category','category_id');
	}
	public function businesses(){
		return $this->hasMany('Business')->orderBy('updated_at')->with('reviews');
	}
}
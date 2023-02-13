<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

	protected $fillable = [
	   'title', 'image', 'status'
	];

	//hasMany relation with Show Model
	public function events()
	{
    	return $this->hasMany(Event::class);
	}

	//hasMany relation with Deal Model
	public function deals()
	{
    	return $this->hasMany(Deal::class);
	}
}

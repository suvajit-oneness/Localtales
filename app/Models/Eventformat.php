<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventformat extends Model
{
    protected $table = 'eventformats';

	protected $fillable = [
	   'name', 'status'
	];

	//hasMany relation with Show Model
	public function events()
	{
    	return $this->hasMany(Event::class);
	}
}

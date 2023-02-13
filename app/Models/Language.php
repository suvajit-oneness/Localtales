<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

	protected $fillable = [
	   'name', 'status'
	];

	//hasMany relation with Show Model
	public function events()
	{
    	return $this->hasMany(Event::class);
	}
}

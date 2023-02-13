<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userbusiness extends Model
{
    protected $table = 'userbusinesses';

	protected $fillable = [
	   'user_id', 'business_id'
	];

	//hasOne relation with Business Model
	public function directory(){
	    return $this->hasOne(Directory::class, 'id', 'directory_id');
	}
}

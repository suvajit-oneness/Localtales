<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userdeal extends Model
{
    protected $table = 'userdeals';

	protected $fillable = [
	   'user_id', 'deal_id'
	];

	//hasOne relation with Deal Model
	public function deal(){
	    return $this->hasOne(Deal::class, 'id', 'deal_id');
	}
}

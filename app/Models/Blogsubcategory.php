<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogsubcategory extends Model
{
    protected $table = 'blogsubcategories';

	protected $fillable = [
	   'title', 'parent_id', 'status'
	];

	//hasMany relation with Blog Model
	public function blogs(){
    	return $this->hasMany(Blog::class);
	}
}

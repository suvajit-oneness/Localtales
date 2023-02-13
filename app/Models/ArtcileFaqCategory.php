<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtcileFaqCategory extends Model
{
    protected $table = 'article_faq_categories';

	protected $fillable = [
	   'title'
	];

	//hasMany relation with Blog Model
	public function blogs(){
    	return $this->hasMany(ArticleFaq::class);
	}
	public function subcategory(){
    	return $this->hasMany(ArticleFaqSubCategory::class);
	}
}

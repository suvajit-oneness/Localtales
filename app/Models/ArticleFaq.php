<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFaq extends Model
{
    protected $table = 'article_faqs';

	protected $fillable = [
	   'title'
	];

    public function category() {
        return $this->belongsTo('App\Models\ArtcileFaqCategory', 'category_id', 'id');
    }
    public function subcategory() {
        return $this->belongsTo('App\Models\ArtcileFaqSubCategory', 'sub_category_id', 'id');
    }
	//hasMany relation with Blog Model
	public function blogs(){
    	return $this->hasMany(ArticleFaq::class);
	}
}

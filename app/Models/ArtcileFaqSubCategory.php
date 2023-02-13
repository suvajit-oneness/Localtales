<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtcileFaqSubCategory extends Model
{
    protected $table = 'article_faq_sub_categories';

	protected $fillable = [
	   'title'
	];

    public function category() {
        return $this->belongsTo('App\Models\ArtcileFaqCategory', 'category_id', 'id');
    }
	//hasMany relation with Blog Model
	public function blogs(){
    	return $this->hasMany(ArticleFaq::class);
	}
}

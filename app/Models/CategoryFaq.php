<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryFaq extends Model
{
    protected $table = 'category_faqs';

	protected $fillable = [
	   'question', 'answer'
	];

    public function category() {
        return $this->belongsTo('App\Models\BlogCategory', 'category_id', 'id');
    }
}

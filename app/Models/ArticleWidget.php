<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;
class ArticleWidget extends Model
{
    protected $table='article_widgets';


    public function blog() {

        return $this->belongsTo('App\Models\Blog', 'blog_id', 'id');

    }

}


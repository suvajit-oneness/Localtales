<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;

class Business extends Authenticatable
{
    protected $table = 'businesses';

	protected $fillable = [
	   'name', 'business_name', 'category_id', 'image', 'email', 'password', 'mobile', 'address','pin', 'lat', 'lon', 'description', 'service_description', 'opening_hour', 'website', 'facebook_link', 'twitter_link', 'instagram_link', 'status', 'is_deleted'
	];

	//hasOne relation with Category Model
	public function category(){
	    return $this->hasOne(Category::class, 'id', 'category_id');
	}

	//hasMany relation with Deal Model
	public function deals(){
    	return $this->hasMany(Deal::class);
	}

	//hasMany relation with Event Model
	public function events(){
    	return $this->hasMany(Event::class);
	}

	//hasMany relation with Deal Model
	public function properties(){
    	return $this->hasMany(Property::class);
	}
}

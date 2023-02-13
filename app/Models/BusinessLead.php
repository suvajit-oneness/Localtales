<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLead extends Model
{
    protected $fillable = [
        'bussiness_name', 'service_description','description','contact_details','login_details','bussiness_address','opening_hour','type','pin','bussiness_address','alt_mobile_no','website','mobile'
    ];

    public function categoryDetails()
    {
        return $this->belongsTo('App\Models\DirectoryCategory', 'category', 'id');
    }
}

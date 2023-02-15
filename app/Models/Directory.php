<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;

class Directory extends Authenticatable implements MustVerifyEmail
{
   // use HasFactory, Notifiable;
   use Notifiable;
    protected $fillable = [
        'name', 'image','email','is_email_verified','password','mobile','address','pin','lat','lon','description','service_description','opening_hour','website','facebook_link','twitter_link','instagram_link','url','public_holiday','status'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function category() {
        return $this->belongsTo('App\Models\DirectoryCategory', 'category_id', 'id');
    }
    public function pin() {
        return $this->belongsTo('App\Models\PinCode', 'pin', 'id');
    }
    public static function insertData($data, $count, $successArr, $failureArr) {
        $value = DB::table('directories')->where('name', $data['name'])->get();
        if($value->count() == 0) {
           DB::table('directories')->insert($data);
            array_push($successArr, $data['name']);
            $count++;
        } else {
            array_push($failureArr, $data['name']);
        }

        // return $count;

        $resp = [
            "count" => $count,
            "successArr" => $successArr,
            "failureArr" => $failureArr
        ];
        return $resp;
    }
   

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}

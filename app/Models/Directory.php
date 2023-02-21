<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\UserCode;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Auth;
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
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateCode()
    {
        $code = rand(1000, 9999);
  
        DirectoryLoginCode::updateOrCreate(
            [ 'business_id' => Auth::guard('business')->user()->id ],
            [ 'code' => $code ]
        );
    
        try {
  
            $details = [
                'title' => 'Mail from localtales.com',
                'code' => $code
            ];
            $data["email"] = Auth::guard('business')->user()->email;
            $data["title"] = 'Mail from localtales.com';
            $data["code"] = $code;
            Mail::send('business.auth.emails-code',  $data, function ($message) use ($data) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);

            });
            //Mail::to(auth()->user()->email)->send(new SendCodeMail($details));
    
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }
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

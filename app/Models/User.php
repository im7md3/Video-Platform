<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function videos()
    {
        return $this->hasMany('App\Models\Video')->where('processed',1)->with('views');
    }

    public function likes() 
    {
        return $this->hasMany('App\Models\Like');
    }

    public function comments() 
    {
        return $this->hasMany('App\Models\Comment');
    }



    public function alert() {
        return $this->hasOne('App\Models\Alert');
    }

    public function videoInHistory()
    {
        return $this->belongsToMany('App\Models\Video', 'video_user', 'user_id', 'video_id')->withPivot(['id','created_at'])->with('views');
    }

    public function views() {
        return $this->hasMany('App\Models\View');
    }

    public function isAdmin(){
        return $this->admin_level>0? true:false;
    }
    public function isSuperAdmin(){
        return $this->admin_level>1? true:false;
    }

    public function getCreatedAtAttribute($value)
    {
        /* return date("d F Y H:i", strtotime($value)); */
        $value = new Carbon($value);  
        return $value->diffForHumans();                     
    
    }

    
}

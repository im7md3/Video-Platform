<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function convertedvideos()
    {
        return $this->hasMany('App\Models\Convertedvideo');
    }

    public function likes() {
        return $this->hasMany('App\Models\Like');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment')->with('user');
    }

    public function views() {
        return $this->hasMany('App\Models\View');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\Video', 'video_user', 'video_id', 'user_id')->withTimestamps()->withPivot('id');
    }

    public function getCreatedAtAttribute($value)
{
    /* return date("d F Y H:i", strtotime($value)); */
    $value = new Carbon($value);  
    return $value->diffForHumans();                     

}
}

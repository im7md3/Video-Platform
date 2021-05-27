<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convertedvideo extends Model
{
    use HasFactory;

    public function video()
    {
        return $this->belongsTo('App\Models\Video');
    }

    public function getCreatedAtAttribute($value)
{
    /* return date("d F Y H:i", strtotime($value)); */
    $value = new Carbon($value);  
    return $value->diffForHumans();                     

}
}

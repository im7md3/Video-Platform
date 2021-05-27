<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index(){
        $date=Carbon::today()->subDays(8);

         $videos = Video::join('views','videos.id','=','views.video_id')->where('processed',1)->where('videos.created_at','>=',$date)->with(['user'])->orderBy('views.views_number',"DESC")->get();
        return Inertia::render('Welcome', compact(['videos']));
    }

    public function search(Request $request){

        
        $videos = Video::join('views','videos.id','=','views.video_id')->where('processed',1)->where('title','like',"%$request->term%")->with(['user'])->orderBy('views.views_number',"DESC")->get();
        return $videos;
        
    }

    public function channelsVideos(User $channel){

        $videos=Video::where('user_id',$channel->id)->with('views')->get();

        return Inertia::render('Videos/my-videos',compact('videos'));
    }

    public function notification(){
        auth()->user()->unreadNotifications->markAsRead();
        $notifications=auth()->user()->notifications()->latest()->get();
        return Inertia::render('Notification',compact('notifications'));
    }
    
    public function readNotification(){
        auth()->user()->unreadNotifications->markAsRead();
    }
    
}

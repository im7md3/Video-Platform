<?php

namespace App\Http\Controllers;

use App\Events\RealNotification;
use App\Models\Like;
use App\Models\User;
use App\Models\Video;
use App\Notifications\LikeNotification;
use App\Notifications\VideoSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request){
        $user=User::find($request->user_id);
       $user->notify(new LikeNotification(auth()->user(),Video::find($request->video_id)));
       
        $alertLogin="";
        if(Auth::check()){
            $user=auth()->user();
            $video=$user->likes()->where('video_id',$request->video_id)->first();
            if($video){
                if($video->like==1){
                    $video->delete();
                }else{
                    $video->update(['like'=>1]);
                }
                
            }else{
                Like::create([
                    'video_id'=>$request->video_id,
                    'user_id'=>auth()->id(),
                    'like'=>1
                ]);
            }
            $userLike=$user->likes()->where('video_id',$request->video_id)->get();
        }else{
            $userLike=[];
            $alertLogin="يجب تسجيل الدخول لكي تستطيع الإعجاب بالفيديو";
        }
        $likeCount=Like::where('video_id',$request->video_id)->where('like',"1")->count();
        $dislikeCount=Like::where('video_id',$request->video_id)->where('like',"0")->count();
        return ['likeCount'=>$likeCount,'dislikeCount'=>$dislikeCount,'userLike'=>$userLike,'alertLogin'=>$alertLogin];
    }

    public function dislike(Request $request){


        $alertLogin="";
        if(Auth::check()){
            $user=auth()->user();
            $video=$user->likes()->where('video_id',$request->video_id)->first();
            if($video){
                if($video->like==0){
                    $video->delete();
                }else{
                    $video->update(['like'=>0]);
                }
            }else{
                Like::create([
                    'video_id'=>$request->video_id,
                    'user_id'=>auth()->id(),
                    'like'=>0
                ]);
            }
            
            $userLike=$user->likes()->where('video_id',$request->video_id)->get();
        }else{
            $userLike=[];
            $alertLogin="يجب تسجيل الدخول لكي تستطيع عدم الإعجاب بالفيديو";
        }
        $likeCount=Like::where('video_id',$request->video_id)->where('like',"1")->count();
        $dislikeCount=Like::where('video_id',$request->video_id)->where('like',"0")->count();
        return ['likeCount'=>$likeCount,'dislikeCount'=>$dislikeCount,'userLike'=>$userLike,'alertLogin'=>$alertLogin];
    }
}

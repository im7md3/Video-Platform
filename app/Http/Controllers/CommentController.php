<?php

namespace App\Http\Controllers;

use App\Events\RealNotification;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use App\Notifications\CommentNotification;
use App\Notifications\VideoSuccess;

class CommentController extends Controller
{
    public function store(CommentRequest $request){
        $user=User::find($request->user_id);
       $user->notify(new CommentNotification(auth()->user(),Video::find($request->video_id)));
        if(auth()->check()){
        $comment=Comment::create([
                'video_id'=>$request->video_id,
                'user_id'=>auth()->id(),
                'body'=>$request->body,
            ]
            );
            return redirect()->back()->with(
                'success',
                'تم اضافة التعليق بنجاح'
            );
        }else{
            return redirect()->back()->with(
                'fail',
                'يجب تسجيل الدخول لنشر تعليق'
            );
        }
        
    }

    public function update(Request $request,$id){
        $comment=Comment::find($id);
        $comment->update(['body'=>$request->body]);
        return redirect()->back()->with(['success'=>'تم تعديل التعليق بنجاح']);
    }

    public function destroy($id){
        $comment=Comment::find($id);
        $comment->delete();
        return redirect()->back()->with(['fail'=>'تم حذف التعليق بنجاح']);
    }
}

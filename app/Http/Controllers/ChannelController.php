<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChannelController extends Controller
{
    public function index(){
        $channels=User::all();
        return Inertia::render('Channel',compact('channels'));
    }

    public function search(Request $request){

        return $channel = User::where('name','like',"%$request->term%")->get();
        
        return $channel;
        
    }

    public function adminIndex(){
        $users=User::with(['videos','views'])->get();
        return Inertia::render('Admin/Channels/index',compact('users'));
    }

    public function adminUpdate(Request $request){
        $user=User::find($request->user_id);
        $user->admin_level=$request->admin_level;
        $user->save();
        return redirect(route('channels.index'))->with(['success'=>'تم تعديل صلاحيات القناة بنجاح']);
    }
    public function adminBlock(Request $request){
        $user=User::find($request->user_id);
        $user->block=!$user->block;
        $user->save();
        return redirect(route('channels.index'))->with(['success'=>'تم حظر القناة بنجاح']);
    }
    public function deleteChannel($id){
        $user=User::find($id);
        $user->delete();
        return redirect(route('channels.index'))->with(['success'=>'تم حذف القناة بنجاح']);
    }
    public function channelBlocked(){
        $users=User::where('block',1)->get();
        return Inertia::render('Admin/Channels/blocked',compact('users'));
    }

    public function allChannels(){
         $channels=User::with('videos')->withCount(['views'=>function($query){
             $query->select(DB::raw('sum(views_number)'));
        }])->get();
        return Inertia::render('Admin/Channels/all',compact('channels'));
    }

}

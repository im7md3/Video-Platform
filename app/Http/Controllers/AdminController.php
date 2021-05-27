<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use App\Models\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(){
        if(Gate::allows('update_videos')){
            $numberOfVideos=Video::count();
            $numberOfChannels=User::count();
            $mostViews = View::select('user_id', DB::raw('sum(views.views_number) as total'))->groupBy('user_id')->orderBy('total','Desc')->take(5)->get();
            $names = [];
            $totalViews = [];
            foreach ($mostViews as $view) {
                array_push($names, User::find($view->user_id)->name);
                array_push($totalViews, $view->total);
            }
            return Inertia::render('Admin/index',compact(['numberOfVideos','numberOfChannels','names','totalViews']));
        }else{
            return redirect()->back()->with(['fail'=>'غيرمصرح لك بدخول هذه الصفحة']);
        }
        
    }

    
}

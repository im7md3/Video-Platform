<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() 
    {
        $this->middleware('auth'); 
    }
    
    public function index()
    {
         $videos=auth()->user()->videoInHistory()->orderByPivot('created_at','DESC')->get();
        return Inertia::render('History/index',compact('videos'));
    }

    public function destroy($id){
        auth()->user()->videoInHistory()->wherePivot('id',$id)->detach();
        return redirect()->route('history.index')->with(['success'=>'تم حذف الفيديو من سجل المشاهدة']);
    }

    public function deleteAll(){
        auth()->user()->videoInHistory()->detach();
        return redirect()->back()->with(['success'=>'تم حذف سجل المشاهدة']);
    }

    }

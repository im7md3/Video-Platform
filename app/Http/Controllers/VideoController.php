<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use App\Jobs\ConvertVideo;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Convertedvideo;
use App\Models\Like;
use App\Models\Video;
use App\Models\View;
use App\Notifications\VideoSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show','addView']);
    }
    public function index()
    {
        
        $videos = auth()->user()->videos;
        $searchState=0;
        return Inertia::render('Videos/my-videos', compact(['videos','searchState']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Videos/uploader");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        $video_path = time() . '-' . $request->video->getClientOriginalName();
        $image_path = imgVideoUpload($request->image);
        $request->video->storeAs('/', $video_path, 'public');
        $video = Video::create([
            'disk'        => 'public',
            'video_path'  => $video_path,
            'image_path'  => $image_path,
            'title'       => $request->title,
            'user_id'     => auth()->id(),
        ]);
        View::create([
            'video_id'=>$video->id,
            'user_id'=>auth()->id(),
            'views_number'=>0
        ]);
        ConvertVideoForStreaming::dispatch($video);
        return redirect()->back()->with(
            'success',
            'سيكون مقطع الفيديو متوفر في أقصر وقت عندما ننتهي من معالجته'
        );
    }


    public function show($id)
    {
        $videoCountLike=Like::where('video_id',$id)->where('like',"1")->count();
        $videoCountDislike=Like::where('video_id',$id)->where('like',"0")->count();
         $view=View::where('video_id',$id)->get();
         $viewCount=$view[0]->views_number;
        $user=auth()->user();
        $video=Video::with(['convertedvideos','comments'=>function($query){
            $query->orderBy('created_at',"DESC");
        }])->find($id);
        if(Auth::check()){
            $userLike=$user->likes()->where('video_id',$id)->get();
            $user->videoInHistory()->attach($video->id,['created_at'=>Carbon::createFromFormat('Y-m-d H:i:s', now())]);
        }else{
            $userLike=[];
        }
        
        
        return Inertia::render('Videos/show',compact(['video','videoCountLike','videoCountDislike','userLike','viewCount']));
    }

    public function edit($id)
    {
        $my_video=Video::find($id);
        return Inertia::render('Videos/edit-video',compact('my_video'));
    }

    public function update(Request $request, $id)
    {

        $video=Video::find($id);
        if($request->image){
            unlink($video->image_path);
            $image_path = imgVideoUpload($request->image);
            $video->image_path=$image_path;
        }
        $video->title=$request->title;
        $video->save();
        if($video){
            return Redirect::back()->with(
                'success',
                'تم تعديل الفيديو بنجاح'
            );
        }else{
            return redirect()->back()->with(
                'fail',
                'حدث خطأ ما أثناء التعديل, الرجاء المحاولة فيما بعد'
            );
        }
    }


    public function destroy($id)
    {
        $video = Video::find($id);
        if ($video->user_id == auth()->id()) {
            $convertedVideos = Convertedvideo::where('video_id', $id)->get();

            foreach ($convertedVideos as $covertedVideo) {

                if ($covertedVideo->mp4_Format_240) {
                    unlink($covertedVideo->mp4_Format_240);
                }

                if ($covertedVideo->mp4_Format_360) {
                    unlink($covertedVideo->mp4_Format_360);
                }

                if ($covertedVideo->mp4_Format_480) {
                    unlink($covertedVideo->mp4_Format_480);
                }

                if ($covertedVideo->mp4_Format_720) {
                    unlink($covertedVideo->mp4_Format_720);
                }

                if ($covertedVideo->mp4_Format_1080) {
                    unlink($covertedVideo->mp4_Format_1080);
                }

                if ($covertedVideo->webm_Format_240) {
                    unlink($covertedVideo->webm_Format_240);
                }

                if ($covertedVideo->webm_Format_360) {
                    unlink($covertedVideo->webm_Format_360);
                }

                if ($covertedVideo->webm_Format_480) {
                    unlink($covertedVideo->webm_Format_480);
                }

                if ($covertedVideo->webm_Format_720) {
                    unlink($covertedVideo->webm_Format_720);
                }

                if ($covertedVideo->webm_Format_1080) {
                    unlink($covertedVideo->webm_Format_1080);
                }
            }
            unlink($video->image_path);

            $video->delete();
            return redirect()->back()->with(
                'success',
                'تم حذف الفيديو بنجاح'
            );
        } else {
            return redirect()->back()->with(
                'fail',
                'لا يمكنك حذف هذا الفيديو'
            );
        }
    }

    public function search(Request $request){

        return $videos = auth()->user()->videos()->where('title','like',"%$request->term%")->get();
        
        return $videos;
        
    }

    public function addView(Request $request){
        $video=View::where('video_id',$request->video_id)->first();
        $views_number=$video->views_number+1;
        $video->update(['views_number'=>$views_number]);
        return $video->views_number;

    }

    public function mostViews(){
        $mostVideos=View::with(['user','video'])->orderBy('views_number','Desc')->take(10)->get(['user_id', 'video_id', 'views_number']);
        $names=[];
        $videoViews=[];
        foreach($mostVideos as $video){
            array_push($names,Video::find($video->video_id)->title);
            array_push($videoViews,$video->views_number);
        }
        return Inertia::render('Admin/MostViews',compact(['mostVideos','names','videoViews']));
    }
}

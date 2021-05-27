<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('language/{language}', function ($language) {
    Session()->put('locale', $language);
 
    return redirect()->back();
})->name('language');

/* Route::get('/', function () {
    return Inertia::render('main');
}); */

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect()->route('welcome');
})->name('dashboard'); 

Route::get('/', [App\Http\Controllers\MainController::class,'index'])->name('welcome');
Route::post('search', [App\Http\Controllers\MainController::class,'search'])->name('search.videos');
Route::resource('videos', App\Http\Controllers\VideoController::class);
Route::post('video/search', [App\Http\Controllers\VideoController::class,'search'])->name('searchInMyVideos');
Route::post('like', [App\Http\Controllers\LikeController::class,'like'])->name('like');
Route::post('dislike', [App\Http\Controllers\LikeController::class,'dislike'])->name('dislike');
Route::post('video/view', [App\Http\Controllers\VideoController::class,'addView'])->name('addView');
Route::resource('comment', App\Http\Controllers\CommentController::class);
Route::resource('history', App\Http\Controllers\HistoryController::class);
Route::delete('logs/delete', [App\Http\Controllers\HistoryController::class,'deleteAll'])->name('history.delete');
Route::get('/{channel:name}/videos', [App\Http\Controllers\MainController::class,'channelsVideos'])->name('channel.videos');
Route::get('/channels', [App\Http\Controllers\ChannelController::class,'index'])->name('channel.index');
Route::get('/channels/search', [App\Http\Controllers\ChannelController::class,'search'])->name('search.channels');
Route::get('/notifications', [App\Http\Controllers\MainController::class,'notification'])->name('all.noti');
Route::post('/notifications', [App\Http\Controllers\MainController::class,'readNotification'])->name('readNot');

Route::prefix('admin')->middleware('can:update_videos')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class,'index'])->name('admin.index');
    Route::get('/channels', [App\Http\Controllers\ChannelController::class,'adminIndex'])->name('channels.index');
    Route::put('/channels/update', [App\Http\Controllers\ChannelController::class,'adminUpdate'])->name('update.permission');
    Route::put('/channels/block', [App\Http\Controllers\ChannelController::class,'adminBlock'])->name('update.block');
    Route::delete('/channels/{id}', [App\Http\Controllers\ChannelController::class,'deleteChannel'])->name('delete.channel');
    Route::get('/channels/blocked', [App\Http\Controllers\ChannelController::class,'channelBlocked'])->name('channel.blocked');
    Route::get('/allChannels', [App\Http\Controllers\ChannelController::class,'allChannels'])->name('channels.all');
    Route::get('/mostViews', [App\Http\Controllers\VideoController::class,'mostViews'])->name('most.views');
});

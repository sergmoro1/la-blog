<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\Post;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//Route::get('/post-index', function () {
    //return view('post', ['action' => 'Index']);
Route::get('/post-index', 
    [App\Http\Controllers\PostController::class, 'index']
)->middleware(['auth'])->name('post-index');

//Route::get('/post/create', function () {
//    return view('post', ['action' => 'Add']);
Route::get('/post-create', 
    [App\Http\Controllers\PostController::class, 'create']
)->middleware(['auth'])->name('post-create');

Route::post('/post-store', 
    [App\Http\Controllers\PostController::class, 'store']
)->middleware(['auth'])->name('post-store');

Route::get('/post-edit/{id}', 
    [App\Http\Controllers\PostController::class, 'edit']
)->middleware(['auth'])->name('post-edit');

Route::post('/post-update/{id}', 
    [App\Http\Controllers\PostController::class, 'update']
)->middleware(['auth'])->name('post-update');

//Route::get('/post/show/{id}', function ($id) {
//    $post = Post::select('title')->find($id);
//    return view('post', ['post_id' => $id, 'post_title' => $post->title, 'action' => 'Show']);
//})->middleware(['auth']);

Route::get('/post-show-modal/{id}', function ($id) {
    $post = Post::FindOrFail($id);
    return view('post.modal.show', ['post' => $post]);
})->middleware(['auth'])->name('post-show-modal');

//Route::post('/post-delete/{id}', 
//    [App\Http\Livewire\Post\Index::class, 'delete']
//)->middleware(['auth']);

require __DIR__.'/auth.php';

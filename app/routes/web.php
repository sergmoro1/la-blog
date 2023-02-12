<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/post-index', function () {
    return view('post', ['action' => 'Index']);
})->middleware(['auth'])->name('post-index');

Route::get('/post-create', function () {
    return view('post', ['action' => 'Form']);
})->middleware(['auth'])->name('post-create');

Route::get('/post-show/{id}', function ($id) {
    return view('post', ['post_id' => $id, 'action' => 'Show']);
})->middleware(['auth'])->name('post-show');

Route::post('/post-delete/{id}', 
    [App\Http\Livewire\Post\Index::class, 'delete']
)->middleware(['auth'])->name('post-delete');

require __DIR__.'/auth.php';

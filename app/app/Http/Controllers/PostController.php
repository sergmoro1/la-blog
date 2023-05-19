<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use app\models\Post;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    /**
     * Show the form for creating new specified resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('post.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}

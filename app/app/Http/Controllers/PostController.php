<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use app\models\Post;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller
{
    /**
     * Показать форму для создания нового сообщения в блоге.
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

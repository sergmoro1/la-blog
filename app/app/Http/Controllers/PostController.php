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
     * Сохранить новую запись в блоге.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        $post = new Post();
        $post->create($request);

        return back()->with('success', 'Post created successfully.');
    }
}

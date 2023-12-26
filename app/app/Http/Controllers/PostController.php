<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\PostTag;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post', ['action' => 'index', 'buttons' => Post::dtButtons()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $post->status = Post::STATUS_DRAFT;

        return view('post', ['post' => $post, 'action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        DB::transaction(function() use ($request, $validated) {
            $post = Post::create($validated);
 
            $links = collect($request->tags)->map(function($tag_id) use ($post) {
                return ['post_id' => $post->id, 'tag_id' => $tag_id];
            });

            PostTag::insert($links->toArray());

            session()->flash('success', __('Entity was successfully added'));
        });

        return redirect()->to('/post-index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('post', ['post' => $post, 'action' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, PostRequest $request)
    {
        $validated = $request->validated();
        
        DB::transaction(function() use ($id, $request, $validated) {
            $post = Post::find($id);
            $post->update($validated);

            PostTag::update_tags($post->id, $request);

            session()->flash('success', __('Entity was successfully added or updated'));
        });
        
        return redirect()->to('post-index');
    }
}

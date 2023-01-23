<?php

namespace App\Http\Livewire\Post;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public $status;
    public $title;
    public $excerpt;
    public $content;
 
    protected function rules()
    {
        return [
            'status' => Rule::in([Post::STATUS_DRAFT, Post::STATUS_PUBLISHED, Post::STATUS_ARCHIVED]),
            'title' => 'required|max:255',
            'excerpt' => 'required',
            'content' => 'required',
        ];
    }

    public function submit()
    {
        $validatedData = $this->validate();
        Post::create($validatedData);
        
        session()->flash('success', __('Entity was successfully added or updated'));
        
        $posts = Post::paginate(config('app.posts_per_page'));
        
        return redirect()->to('/post-index?page=' . $posts->lastPage());
    }
    
    public function render()
    {
        return view('livewire.post.form');
    }
}

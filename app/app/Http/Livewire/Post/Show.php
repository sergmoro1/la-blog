<?php

namespace App\Http\Livewire\Post;

use Livewire\Component;
use App\Models\Post;

class Show extends Component
{
    protected $post_id;
 
    public function mount($post_id)
    {
        $this->post_id = $post_id;
    }
    
    public function render()
    {
        $post = Post::FindOrFail($this->post_id);
        return view('livewire.post.show', ['post' => $post]);
    }
}

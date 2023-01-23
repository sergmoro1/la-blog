<?php

namespace App\Http\Livewire\Post;

use Livewire\Component;

class Show extends Component
{
    protected $post;
 
    public function mount($post)
    {
        $this->post = $post;
    }
    
    public function render()
    {
        return view('livewire.post.show', ['post' => $this->post]);
    }
}

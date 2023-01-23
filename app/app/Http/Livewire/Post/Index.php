<?php

namespace App\Http\Livewire\Post;

use Livewire\Component;
use App\Models\Post;

class Index extends Component
{
    protected $listeners = [
        'post-delete'=>'delete',
    ];
    
    public function delete($id, $page)
    {
        try {
            Post::find($id)->delete();
            session()->flash('success', __("Entity deleted succsessfully"));
        } catch(\Exception $e) {
            session()->flash('error', __("Something goes wrong while deleting!"));
        }
        return redirect()->to('/post-index?page=' . $page);
    }
    
    public function render()
    {
        $posts = Post::paginate(config('app.posts_per_page'));
        
        return view('livewire.post.index', [
            'posts' => $posts,
            'page'  => Post::getCurrentPageAfterDeletion($posts),
        ]);
    }
}

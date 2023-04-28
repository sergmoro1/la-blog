<?php

namespace App\Http\Livewire\Post;

use Livewire\Component;
use App\Models\Post;

class Indexjs extends Component
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
        return redirect()->to('/post-indexjs?page=' . $page);
    }
    
    public function render()
    {
        return view('livewire.post.indexjs');
    }
}

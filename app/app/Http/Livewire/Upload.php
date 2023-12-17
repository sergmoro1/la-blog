<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Upload extends Component
{
    public $model;
    
    public function render()
    {
        return view('livewire.upload');
    }
}

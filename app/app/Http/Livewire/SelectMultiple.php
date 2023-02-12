<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectMultiple extends Component
{
    public $field;
    public $label;
    public $options;

    public function render()
    {
        return view('livewire.select-multiple');
    }
}

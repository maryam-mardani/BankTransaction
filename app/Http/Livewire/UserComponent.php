<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserComponent extends Component
{
    public $title = 'Users';

     
    public function mount()
    {

    }

    public function render()
    {
        return view('livewire.user-component');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class LeftSideDescription extends Component
{
    public $logoPath = 'images/logo.png';

    public function render()
    {
        return view('livewire.left-side-description');
    }
}

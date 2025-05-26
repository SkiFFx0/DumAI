<?php

namespace App\Livewire;

use Cloudstudio\Ollama\Facades\Ollama;
use Livewire\Component;

class OllamaTest extends Component
{
    public $aiResponse = '';

    public function mount()
    {
        $tempResponse = (object)Ollama::prompt('Write 1 quote about importance of life and only that')->ask();

        $this->aiResponse = $tempResponse->response;
    }

    public function render()
    {
        return view('livewire.ollama-test');
    }
}

<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $email = '';
    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password]))
        {
            return redirect()->route('chat');
        }

        $this->addError('submit', 'Invalid credentials');
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}

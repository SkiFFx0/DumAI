<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegisterForm extends Component
{
    public $logoPath = 'images/logo.png';
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:8',
    ];

    public function register()
    {
        $validated = $this->validate();

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('chat');
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}

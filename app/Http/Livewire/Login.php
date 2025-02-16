<?php

namespace App\Http\Livewire;  
  
use Livewire\Component;  
use Illuminate\Support\Facades\Auth;  
use Illuminate\Validation\ValidationException;  
  
class Login extends Component  
{  
    public $username;  
    public $password;  
  
    protected $rules = [  
        'username' => 'required|string',  
        'password' => 'required|string',  
    ];  
  
    public function login()  
    {  
        $this->validate();  
  
        if (!Auth::attempt(['username' => $this->username, 'password' => $this->password])) {  
            throw ValidationException::withMessages([  
                'username' => 'The provided credentials are incorrect.',  
            ]);  
        }  
  
        session()->regenerate();  
  
        return redirect()->intended('/dashboard-admin'); // Change this to your intended route  
    }  
  
    public function render()  
    {  
        return view('livewire.login');  
    }  
}  


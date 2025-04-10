<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerificationCode;

class ForgotPassword extends Component
{
    public $email;
    public $verificationCode;
    public $enteredCode;
    public $newPassword;
    public $newPasswordConfirmation;
    public $step = 1;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'enteredCode' => 'required|string|min:4|max:4',
        'newPassword' => 'required|min:8|confirmed',
        'newPasswordConfirmation' => 'required'
    ];

    protected $messages = [
        'email.required' => 'Email harus diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.exists' => 'Email tidak terdaftar.',
        'enteredCode.required' => 'Kode verifikasi harus diisi.',
        'enteredCode.min' => 'Kode verifikasi harus 4 digit.',
        'enteredCode.max' => 'Kode verifikasi harus 4 digit.',
        'newPassword.required' => 'Password baru harus diisi.',
        'newPassword.min' => 'Password minimal harus 8 karakter.',
        'newPassword.confirmed' => 'Konfirmasi password tidak cocok.',
        'newPasswordConfirmation.required' => 'Konfirmasi password harus diisi.'
    ];

    public function sendVerificationCode()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $this->verificationCode = sprintf('%04d', rand(0, 9999));
        
        // Store verification code in session
        session()->put('verification_code', $this->verificationCode);
        session()->put('verification_email', $this->email);
    
        // Send email with verification code
        Mail::to($this->email)->send(new VerificationCode($this->verificationCode));
    
        $this->step = 2;
        session()->flash('message', 'Verification code has been sent to your email.');
    }

    public function verifyCode()
    {
        $this->validate([
            'enteredCode' => 'required|string|min:4|max:4'
        ]);

        if ($this->enteredCode === session('verification_code')) {
            $this->step = 3;
        } else {
            $this->addError('enteredCode', 'Invalid verification code.');
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:8|confirmed',
            'newPasswordConfirmation' => 'required'
        ]);

        $user = User::where('email', session('verification_email'))->first();
        $user->password = Hash::make($this->newPassword);
        $user->save();

        session()->forget(['verification_code', 'verification_email']);
        
        session()->flash('message', 'Password has been reset successfully.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.forgot-password');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
       // Ambil user yang sedang login
       $user = Auth::user();

       // Pastikan data user ditemukan
       if (!$user) {
           return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Simpan role ke session
       session(['role' => $user->role]);

       // Kirim data user ke view
       return view('editProfile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        // Base validation rules for profile
        $rules = [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'required|string',
        ];

        // Add password validation rules if password is being updated
        if ($request->filled('current_password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:8|confirmed';
        }

        $request->validate($rules);

        // Update profile information
        $user->username = $request->username;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->address = $request->alamat;

        // Update password if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }
}

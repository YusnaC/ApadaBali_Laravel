<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'required|string',
        ]);

        $user->username = $request->username;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->address = $request->alamat;
        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }
}

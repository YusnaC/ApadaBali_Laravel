<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        // Get logged in user ID
        $userId = Auth::id();

        // Get fresh user data from database
        $user = DB::table('users')
            ->where('id', $userId)
            ->first();

        // Check if user exists
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Store role in session
        session(['role' => $user->role]);

        // Send user data to view
        return view('editProfile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('current_password') || $request->filled('password')) {
            $passwordRules = [
                'current_password' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password'
            ];

            $passwordMessages = [
                'current_password.required' => 'Password saat ini wajib diisi',
                'password.required' => 'Password baru wajib diisi',
                'password.min' => 'Password baru minimal 8 karakter',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi',
                'password_confirmation.same' => 'Konfirmasi password tidak sesuai'
            ];

            $validator = validator($request->all(), $passwordRules, $passwordMessages);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai'])->withInput();
            }

            if (Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama'])->withInput();
            }

            $user->update(['password' => Hash::make($request->password)]);
            return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui');
        }

        $rules = [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'required|string',
        ];

        if ($user->role === 'drafter') {
            $rules['no_hp'] = 'required|digits_between:10,15';
        }

        $messages = [
            'username.required' => 'Username wajib diisi',
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'email.email' => 'Format email tidak valid',
            'username.unique' => 'Username sudah digunakan',
            'email.unique' => 'Email sudah digunakan',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi',
            'no_whatsapp.digits_between' => 'Nomor WhatsApp harus terdiri dari 10 sampai 15 digit',
        ];

        $request->validate($rules, $messages);

        try {
            DB::beginTransaction();

            $updateData = [
                'username' => $request->username,
                'name' => $request->nama,
                'email' => $request->email,
                'address' => $request->alamat,
                'phone' => $request->no_hp ?? $user->phone,
            ];

            $user->update($updateData);

            DB::commit();

            return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate profile: ' . $e->getMessage()]);
        }
    }
}

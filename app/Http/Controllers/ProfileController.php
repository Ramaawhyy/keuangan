<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function showProfile()
    {
        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Kirim data pengguna ke view
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Validasi input dari pengguna
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:8|confirmed',
            'current_password' => 'nullable|string|min:8', // Validasi kata sandi saat ini
        ]);

        // Jika validasi gagal, kembalikan ke form dengan pesan kesalahan
        if ($validator->fails()) {
            return redirect()->route('profile.index')->withErrors($validator)->withInput();
        }

        // Ambil data pengguna yang sedang login
        $userId = Auth::id();

        // Update data pengguna dengan query builder
        $updateData = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ];

        // Update password jika diubah
        if ($request->filled('password') && Hash::check($request->input('current_password'), Auth::user()->password)) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        // Gunakan query builder untuk memperbarui data pengguna
        DB::table('users')->where('id', $userId)->update($updateData);

        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}

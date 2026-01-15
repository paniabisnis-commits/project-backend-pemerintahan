<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        // Hapus avatar lama jika ada
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Simpan avatar baru
        $path = $request->file('avatar')->store(
            'avatars/admin',
            'public'
        );

        $user->update([
            'avatar' => $path,
        ]);

        return response()->json([
            'message' => 'Avatar berhasil diperbarui',
            'avatar_url' => asset('storage/' . $path),
        ]);
    }
}

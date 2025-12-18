<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    // ==========================
    // USER: Kirim pengaduan
    // ==========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengadu'  => 'required|string|max:255',
            'email'         => 'required|email',
            'isi_pengaduan' => 'required|string',
        ]);

        $complaint = Complaint::create($validated);

        return response()->json([
            'message' => 'Pengaduan berhasil dikirim',
            'data' => $complaint
        ], 201);
    }

    // ==========================
    // ADMIN: Lihat semua pengaduan
    // ==========================
    public function adminIndex()
    {
        $complaints = Complaint::latest()->get();

        return response()->json([
            'message' => 'Daftar semua pengaduan',
            'data' => $complaints
        ]);
    }
}

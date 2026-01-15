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
    $request->validate([
        'isi_pengaduan' => 'required|string'
    ]);

    $user = $request->user(); // ← INI YANG BENAR DI API

    $complaint = Complaint::create([
        'nama_pengadu' => $user->name,
        'email' => $user->email,
        'isi_pengaduan' => $request->isi_pengaduan,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Pengaduan berhasil dikirim',
        'data' => $complaint
    ], 201);
}

    public function index()
    {
        return response()->json([
            'data' => Complaint::latest()->get()
        ]);
    }

    public function adminIndex()
{
    return response()->json([
        'data' => Complaint::latest()->get()
    ]);
}

// ==========================
// ADMIN: Update status pengaduan
// ==========================
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:baru,diproses,selesai'
    ]);

    $complaint = Complaint::find($id);

    if (!$complaint) {
        return response()->json([
            'success' => false,
            'message' => 'Pengaduan tidak ditemukan'
        ], 404);
    }

    $complaint->status = $request->status;
    $complaint->save();

    return response()->json([
        'success' => true,
        'message' => 'Status pengaduan berhasil diperbarui',
        'data' => $complaint
    ]);
}

    public function destroy(Request $request, $id)
        {
            $complaint = Complaint::find($id);

            if (!$complaint) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengaduan tidak ditemukan'
                ], 404);
            }

            // hanya admin
            if ($request->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki izin'
                ], 403);
            }

            $complaint->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengaduan berhasil dihapus'
            ]);
        }

}


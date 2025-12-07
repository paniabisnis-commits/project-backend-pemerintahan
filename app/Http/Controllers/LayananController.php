<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;


class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $data = Layanan::all();   // Mengambil semua data layanan

    return response()->json([
        'success' => true,
        'message' => 'List semua layanan',
        'data' => $data
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
    $request->validate([
        'kategori' => 'required',
        'nama_layanan' => 'required',
        'deskripsi' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    // 2. Upload gambar jika ada
    $path = null;
    if ($request->hasFile('gambar')) {
        $path = $request->file('gambar')->store('layanan', 'public'); 
    }

    // 3. Simpan data ke database
    $layanan = Layanan::create([
        'kategori' => $request->kategori,
        'nama_layanan' => $request->nama_layanan,
        'deskripsi' => $request->deskripsi,
        'gambar' => $path
    ]);

    // 4. Response
    return response()->json([
        'success' => true,
        'message' => 'Layanan berhasil dibuat',
        'data' => $layanan
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $layanan = Layanan::find($id);

    // Jika data tidak ditemukan
    if (!$layanan) {
        return response()->json([
            'success' => false,
            'message' => 'Layanan tidak ditemukan'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Detail layanan',
        'data' => $layanan
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Cari layanan
    $layanan = Layanan::find($id);

    if (!$layanan) {
        return response()->json([
            'success' => false,
            'message' => 'Layanan tidak ditemukan'
        ], 404);
    }

    // 2. Validasi
    $request->validate([
        'kategori' => 'required',
        'nama_layanan' => 'required',
        'deskripsi' => 'required',
        'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    // 3. Upload gambar baru (jika ada)
    if ($request->hasFile('gambar')) {
        $path = $request->file('gambar')->store('layanan', 'public');
        $layanan->gambar = $path;
    }

    // 4. Update field lainnya
    $layanan->update([
        'kategori' => $request->kategori,
        'nama_layanan' => $request->nama_layanan,
        'deskripsi' => $request->deskripsi
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Layanan berhasil diupdate',
        'data' => $layanan
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $layanan = Layanan::find($id);

    if (!$layanan) {
        return response()->json([
            'success' => false,
            'message' => 'Layanan tidak ditemukan'
        ], 404);
    }

    $layanan->delete();

    return response()->json([
        'success' => true,
        'message' => 'Layanan berhasil dihapus'
    ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;


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
    'kategori' => 'sometimes|required',
    'nama_layanan' => 'sometimes|required',
    'deskripsi' => 'sometimes|required',
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

public function update(Request $request, string $id)
{
    $layanan = Layanan::find($id);

    if (!$layanan) {
        return response()->json([
            'success' => false,
            'message' => 'Layanan tidak ditemukan'
        ], 404);
    }

    // VALIDASI (PATCH → optional)
    $request->validate([
        'kategori' => 'sometimes|required',
        'nama_layanan' => 'sometimes|required',
        'deskripsi' => 'sometimes|required',
        'gambar' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // UPDATE FIELD TEXT
    if ($request->has('kategori')) {
        $layanan->kategori = $request->kategori;
    }

    if ($request->has('nama_layanan')) {
        $layanan->nama_layanan = $request->nama_layanan;
    }

    if ($request->has('deskripsi')) {
        $layanan->deskripsi = $request->deskripsi;
    }

    // ✅ UPDATE GAMBAR (INI KUNCI)
    if ($request->hasFile('gambar')) {

        // hapus gambar lama
        if ($layanan->gambar) {
            Storage::disk('public')->delete($layanan->gambar);
        }

        // simpan gambar baru
        $path = $request->file('gambar')->store('layanan', 'public');
        $layanan->gambar = $path;
    }

    // 🔥 WAJIB
    $layanan->save();

    return response()->json([
        'success' => true,
        'message' => 'Layanan berhasil diupdate',
        'data' => $layanan
    ]);
}
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

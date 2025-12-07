<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // ========== CREATE (STORE) ==========
    public function store(Request $r)
    {
        $r->validate([
            'kategori'      => 'required|string|max:255',
            'nama_layanan'  => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'gambar'        => 'nullable|image|max:2048'
        ]);

        // Upload file jika ada
        $path = $r->hasFile('gambar')
            ? $r->file('gambar')->store('layanan', 'public')
            : null;

        // Simpan data ke database
        $service = Service::create(array_merge(
            $r->only('kategori','nama_layanan','deskripsi'),
            ['gambar' => $path]
        ));

        return response()->json($service, 201);
    }

    // fungsi CRUD lain bisa disusul di bawahnya...
}

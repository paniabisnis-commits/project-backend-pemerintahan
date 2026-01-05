<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * GET /api/berita
     * List berita
     */
    public function index()
    {
        $berita = Berita::select(
                'id',
                'title',
                'slug',
                'content',
                'image',
                'created_at'
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $berita
        ]);
    }

    /**
     * POST /api/berita
     * Simpan berita baru + auto slug
     */
    public function store(Request $r)
    {
        $r->validate([
            'title'   => 'required|string',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        // ===============================
        // GENERATE SLUG (UNIK)
        // ===============================
        $slug = Str::slug($r->title);
        $count = Berita::where('slug', 'like', "$slug%")->count();

        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        // ===============================
        // UPLOAD IMAGE
        // ===============================
        $imagePath = null;
        if ($r->hasFile('image')) {
            $imagePath = $r->file('image')->store('news', 'public');
        }

        // ===============================
        // SIMPAN DATA
        // ===============================
        $berita = Berita::create([
            'title'   => $r->title,
            'slug'    => $slug,
            'content' => $r->content,
            'image'   => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan',
            'data'    => $berita
        ], 201);
    }

    /**
     * GET /api/berita/{slug}
     * Detail berita by slug
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->first();

        if (!$berita) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }

    /**
     * PUT /api/berita/{id}
     * Update berita + update slug jika title berubah
     */
    public function update(Request $r, $id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        $r->validate([
            'title'   => 'sometimes|string',
            'content' => 'sometimes|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        // ===============================
        // UPDATE SLUG JIKA TITLE DIUBAH
        // ===============================
        if ($r->filled('title') && $r->title !== $berita->title) {
            $slug = Str::slug($r->title);
            $count = Berita::where('slug', 'like', "$slug%")
                ->where('id', '!=', $berita->id)
                ->count();

            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }

            $berita->slug = $slug;
            $berita->title = $r->title;
        }

        // ===============================
        // UPDATE IMAGE JIKA ADA
        // ===============================
        if ($r->hasFile('image')) {
            if ($berita->image && Storage::disk('public')->exists($berita->image)) {
                Storage::disk('public')->delete($berita->image);
            }

            $berita->image = $r->file('image')->store('news', 'public');
        }

        // ===============================
        // UPDATE CONTENT
        // ===============================
        if ($r->filled('content')) {
            $berita->content = $r->content;
        }

        $berita->save();

        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diperbarui',
            'data' => $berita
        ]);
    }

    /**
     * DELETE /api/berita/{id}
     */
    public function destroy($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if ($berita->image && Storage::disk('public')->exists($berita->image)) {
            Storage::disk('public')->delete($berita->image);
        }

        $berita->delete();

        return response()->json([
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}

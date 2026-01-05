<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // GET /api/berita (pagination, search, limit)
    public function index()
{
    $berita = Berita::query()
        ->select('id', 'title', 'content', 'image', 'created_at')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'data' => $berita
    ]);
}

    // POST /api/berita
    public function store(Request $r)
    {
        $r->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        // Upload image
        $imagePath = $r->file('image')
            ? $r->file('image')->store('news', 'public')
            : null;

        $berita = Berita::create([
            'title'   => $r->title,
            'content' => $r->content,
            'image'   => $imagePath,
        ]);

        return response()->json($berita, 201);
    }

    // GET /api/berita/{berita}
    public function show($id)
{
    $berita = Berita::find($id);

    if (!$berita) {
        return response()->json([
            'success' => false,
            'message' => 'Berita tidak ditemukan',
            'data' => null
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Detail berita ditemukan',
        'data' => $berita
    ]);
}


    // PUT/PATCH /api/berita/{berita}
    public function update(Request $r, Berita $berita)
    {
        $r->validate([
            'title' => 'sometimes',
            'content' => 'sometimes',
            'image' => 'nullable|image|max:2048',
        ]);

        // If upload new image, replace old
        if ($r->file('image')) {
            if ($berita->image && Storage::disk('public')->exists($berita->image)) {
                Storage::disk('public')->delete($berita->image);
            }

            $berita->image = $r->file('image')->store('news', 'public');
        }

        // Update text fields
        $berita->update($r->only(['title', 'content']));

        return $berita;
    }

    // DELETE /api/berita/{berita}
    public function destroy($id)
{
    $berita = Berita::find($id);

    if (!$berita) {
        return response()->json([
            'message' => 'Data not found'
        ], 404);
    }

    $berita->delete();

    return response()->json([
        'message' => 'Deleted'
    ], 200);
}

}

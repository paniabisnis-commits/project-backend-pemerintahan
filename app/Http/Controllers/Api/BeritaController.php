<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index(Request $r)
    {
        $query = Berita::query();

        if ($r->search) {
            $query->where('title', 'like', "%{$r->search}%");
        }

        if ($r->limit) {
            return $query->latest()->take($r->limit)->get();
        }

        return $query->latest()->paginate(10);
    }

    public function store(Request $r)
    {
        $r->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $image = $r->file('image') ? $r->file('image')->store('news', 'public') : null;

        $news = Berita::create([
            'title' => $r->title,
            'content' => $r->content,
            'image' => $image
        ]);

        return response()->json($news, 201);
    }

    public function show(Berita $news)
    {
        return $news;
    }

    public function update(Request $r, Berita $news)
    {
        $r->validate([
            'title' => 'sometimes',
            'content' => 'sometimes',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($r->file('image')) {
            $news->image = $r->file('image')->store('news', 'public');
        }

        $news->update($r->only(['title', 'content']));

        return $news;
    }

    public function destroy(Berita $news)
    {
        $news->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
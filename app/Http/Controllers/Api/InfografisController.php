<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Infografis;

class InfografisController extends Controller
{
    public function index(Request $r)
    {
        $query = Infografis::query();

        if ($r->search) {
            $query->where('title', 'like', "%{$r->search}%");
        }

        return $query->latest()->paginate(10);
    }

    public function store(Request $r)
    {
        $r->validate([
            'title' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        $image = $r->file('image')->store('infographics', 'public');

        $infographics = Infografis::create([
            'title' => $r->title,
            'image' => $image
        ]);

        return response()->json($infographics, 201);
    }

    public function show(Infografis $infographic)
    {
        return $infographic;
    }

    public function update(Request $r, Infografis $infographic)
    {
        $r->validate([
            'title' => 'sometimes',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($r->image) {
            $infographic->image = $r->file('image')->store('infographics', 'public');
        }

        $infographic->update($r->only('title'));

        return $infographic;
    }

    public function destroy(Infografis $infographic)
    {
        $infographic->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

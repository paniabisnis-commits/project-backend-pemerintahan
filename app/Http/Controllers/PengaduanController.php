<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|size:16',
            'nama' => 'required',
            'isi_pengaduan' => 'required'
        ]);

        return Pengaduan::create($request->all());
    }

    public function index()
    {
        return Pengaduan::orderBy('created_at','desc')->get();
    }

    public function show($id)
    {
        return Pengaduan::findOrFail($id);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status'=>'required']);

        $p = Pengaduan::findOrFail($id);
        $p->update(['status' => $request->status]);

        return $p;
    }
}


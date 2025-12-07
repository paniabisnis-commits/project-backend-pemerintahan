<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function store(Request $r)
    {
        $r->validate([
            'nama_pengadu'   => 'required',
            'isi_pengaduan'  => 'required'
        ]);

        $c = Complaint::create(
            $r->only('nama_pengadu','email','isi_pengaduan')
        );

        return response()->json($c, 201);
    }
}
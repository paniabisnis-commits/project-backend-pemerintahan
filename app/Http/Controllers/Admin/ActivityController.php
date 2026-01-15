<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Event;
use App\Models\Layanan;
use App\Models\Complaint;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    public function index(): JsonResponse
    {
        $activities = collect();

        // 🔹 Berita terbaru
        $berita = Berita::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'berita',
                    'title' => $item->judul ?? $item->title,
                    'created_at' => $item->created_at->format('Y-m-d H:i'),
                ];
            });

        // 🔹 Event terbaru
        $events = Event::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'event',
                    'title' => $item->judul ?? $item->title,
                    'created_at' => $item->created_at->format('Y-m-d H:i'),
                ];
            });

        // 🔹 Layanan terbaru (opsional)
        $layanan = Layanan::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'layanan',
                    'title' => $item->nama ?? $item->title,
                    'created_at' => $item->created_at->format('Y-m-d H:i'),
                ];
            });

            $pengaduan = Complaint::latest()
    ->take(5)
    ->get()
    ->map(function ($item) {
        return [
            'type' => 'pengaduan',
            'title' => 'Pengaduan dari ' . $item->nama_pengadu,
            'created_at' => $item->created_at->format('Y-m-d H:i'),
        ];
    });


        $activities = $activities
            ->merge($berita)
            ->merge($events)
            ->merge($layanan)
            ->merge($pengaduan)
            ->sortByDesc('created_at')
            ->values()
            ->take(10);

        return response()->json([
            'status' => true,
            'data' => $activities,
        ]);
    }
}

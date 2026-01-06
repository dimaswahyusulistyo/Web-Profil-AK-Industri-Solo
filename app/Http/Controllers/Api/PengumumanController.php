<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Get all pengumuman with pagination
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search');

            $query = Pengumuman::orderBy('created_at', 'desc');

            if ($search) {
                $query->where('judul', 'like', '%' . $search . '%');
            }

            $pengumuman = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $pengumuman->items(),
                'meta' => [
                    'current_page' => $pengumuman->currentPage(),
                    'last_page' => $pengumuman->lastPage(),
                    'per_page' => $pengumuman->perPage(),
                    'total' => $pengumuman->total(),
                ],
                'message' => 'Data pengumuman berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pengumuman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single pengumuman by ID
     */
    public function show($id)
    {
        try {
            $pengumuman = Pengumuman::where('url_halaman', $id)->first();

            if (!$pengumuman && is_numeric($id)) {
                $pengumuman = Pengumuman::find($id);
            }

            if (!$pengumuman) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengumuman tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $pengumuman,
                'message' => 'Detail pengumuman berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail pengumuman',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get latest pengumuman
     */
    public function latest($limit = 5)
    {
        try {
            $pengumuman = Pengumuman::orderBy('created_at', 'desc')
                ->limit($limit)
                ->get(['id', 'judul', 'url_halaman', 'created_at']);

            return response()->json([
                'success' => true,
                'data' => $pengumuman,
                'message' => 'Pengumuman terbaru berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil pengumuman terbaru',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
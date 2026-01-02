<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Get all berita with pagination
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search');
            $kategori = $request->get('kategori');

            $query = Berita::with('kategori:id,nama_kategori,url_halaman')
                ->orderBy('created_at', 'desc');

            // Filter by search
            if ($search) {
                $query->where('judul', 'like', '%' . $search . '%');
            }

            // Filter by kategori
            if ($kategori) {
                $query->whereHas('kategori', function($q) use ($kategori) {
                    $q->where('id', $kategori)
                        ->orWhere('url_halaman', $kategori);
                });
            }

            $berita = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $berita->items(),
                'meta' => [
                    'current_page' => $berita->currentPage(),
                    'last_page' => $berita->lastPage(),
                    'per_page' => $berita->perPage(),
                    'total' => $berita->total(),
                ],
                'message' => 'Data berita berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data berita',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single berita by URL
     */
    public function showByUrl($url)
    {
        try {
            $berita = Berita::with('kategori:id,nama_kategori,url_halaman')
                ->where('url_halaman', $url)
                ->first();

            if (!$berita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $berita,
                'message' => 'Detail berita berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail berita',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single berita by ID
     */
    public function show($id)
    {
        try {
            // Coba cari berdasarkan url_halaman (slug) dahulu
            $berita = Berita::with('kategori:id,nama_kategori,url_halaman')
                ->where('url_halaman', $id)
                ->first();

            // Jika tidak ditemukan, coba cari berdasarkan ID
            if (!$berita && is_numeric($id)) {
                $berita = Berita::with('kategori:id,nama_kategori,url_halaman')
                    ->find($id);
            }

            if (!$berita) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berita tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $berita,
                'message' => 'Detail berita berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail berita',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get latest berita
     */
    public function latest($limit = 5)
    {
        try {
            $berita = Berita::with('kategori:id,nama_kategori')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get(['id', 'judul', 'url_halaman', 'thumbnail', 'created_at']);

            return response()->json([
                'success' => true,
                'data' => $berita,
                'message' => 'Berita terbaru berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil berita terbaru',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all kategori berita
     */
    public function kategori()
    {
        try {
            $kategori = KategoriBerita::orderBy('nama_kategori', 'asc')
                ->get(['id', 'nama_kategori', 'url_halaman', 'created_at']);

            return response()->json([
                'success' => true,
                'data' => $kategori,
                'message' => 'Data kategori berita berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
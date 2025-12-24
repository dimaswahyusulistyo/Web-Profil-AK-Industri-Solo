<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Get all layanan
     */
    public function index()
    {
        try {
            $layanan = Layanan::orderBy('urutan', 'asc')
                ->get(['id', 'nama_layanan', 'ikon', 'tautan', 'urutan', 'created_at']);

            return response()->json([
                'success' => true,
                'data' => $layanan,
                'message' => 'Data layanan berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single layanan by ID
     */
    public function show($id)
    {
        try {
            $layanan = Layanan::find($id);

            if (!$layanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $layanan,
                'message' => 'Detail layanan berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail layanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
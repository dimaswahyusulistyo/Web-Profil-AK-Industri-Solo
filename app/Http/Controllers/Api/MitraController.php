<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    /**
     * Get all mitra
     */
    public function index()
    {
        try {
            $mitra = Mitra::orderBy('urutan', 'asc')
                ->get(['id', 'nama_mitra', 'logo', 'url', 'urutan', 'created_at']);

            return response()->json([
                'success' => true,
                'data' => $mitra,
                'message' => 'Data mitra berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data mitra',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single mitra by ID
     */
    public function show($id)
    {
        try {
            $mitra = Mitra::find($id);

            if (!$mitra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mitra tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $mitra,
                'message' => 'Detail mitra berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail mitra',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
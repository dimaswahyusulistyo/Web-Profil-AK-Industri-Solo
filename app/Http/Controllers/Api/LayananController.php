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
                ->get(['id', 'nama_layanan', 'ikon', 'tautan', 'urutan', 'created_at'])
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nama_layanan' => $item->nama_layanan,
                        'ikon' => $item->ikon ? url('storage/'.$item->ikon) : null, // URL lengkap
                        'tautan' => $item->tautan,
                        'urutan' => $item->urutan,
                        'created_at' => $item->created_at,
                    ];
                });

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
            $layanan->ikon = $layanan->ikon ? url('storage/'.$layanan->ikon) : null;

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

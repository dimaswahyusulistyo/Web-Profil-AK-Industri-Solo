<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Get all active sliders
     */
    public function index()
    {
        try {
            $sliders = Slider::orderBy('urutan', 'asc')
                ->get(['id', 'judul', 'gambar', 'url', 'urutan', 'created_at']);

            return response()->json([
                'success' => true,
                'data' => $sliders,
                'message' => 'Data slider berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data slider',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single slider by ID
     */
    public function show($id)
    {
        try {
            $slider = Slider::find($id);

            if (!$slider) {
                return response()->json([
                    'success' => false,
                    'message' => 'Slider tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $slider,
                'message' => 'Detail slider berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail slider',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
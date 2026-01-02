<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KontenBiasa;
use Illuminate\Http\JsonResponse;

class KontenBiasaController extends Controller
{
    /**
     * Mendapatkan semua halaman
     */
    public function index(): JsonResponse
    {
        $pages = KontenBiasa::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $pages
        ]);
    }

    /**
     * Mendapatkan detail halaman berdasarkan ID
     */
    public function show($id): JsonResponse
    {
        $page = KontenBiasa::with(['form.fields' => fn($q) => $q->orderBy('order')])->find($id);

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Halaman tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $page
        ]);
    }

    /**
     * Mendapatkan halaman berdasarkan URL
     */
    public function showByUrl($url): JsonResponse
    {
        $page = KontenBiasa::with(['form.fields' => fn($q) => $q->orderBy('order')])->where('url_halaman', $url)->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Halaman tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $page
        ]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AspirasiAduan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AspirasiAduanController extends Controller
{
    /**
     * Menyimpan aspirasi/aduan baru
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:20',
            'kategori_aduan_id' => 'required|exists:kategori_aduans,id',
            'pesan' => 'required|string',
            'data_dukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'kategori_aduan_id' => $request->kategori_aduan_id,
            'pesan' => $request->pesan,
        ];

        if ($request->hasFile('data_dukung')) {
            $data['data_dukung'] = $request->file('data_dukung')->store('aspirasi-dukung', 'public');
        }

        $aspirasi = AspirasiAduan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Aspirasi/Aduan berhasil dikirim',
            'data' => $aspirasi->load('kategori')
        ], 201);
    }

    /**
     * Mendapatkan aspirasi/aduan berdasarkan email (untuk tracking)
     */
    public function getByEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $aspirasi = AspirasiAduan::where('email', $request->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $aspirasi
        ]);
    }
}
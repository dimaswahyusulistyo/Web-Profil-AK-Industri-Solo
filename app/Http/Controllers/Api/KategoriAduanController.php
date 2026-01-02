<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriAduan;
use Illuminate\Http\JsonResponse;

class KategoriAduanController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = KategoriAduan::all();
        
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $footer = FooterSetting::first();

        if (!$footer) {
            return response()->json([
                'success' => true,
                'message' => 'No footer settings found',
                'data' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Footer settings retrieved successfully',
            'data' => $footer
        ]);
    }
}

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

        // If no footer setting exists, return default or empty structure
        if (!$footer) {
            return response()->json([
                'success' => true,
                'message' => 'No footer settings found',
                'data' => null
            ]);
        }

        // Return the footer data directly
        // The quick_links and related_links are already cast to array in the model
        return response()->json([
            'success' => true,
            'message' => 'Footer settings retrieved successfully',
            'data' => $footer
        ]);
    }
}

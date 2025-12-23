<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    /**
     * Mendapatkan semua menu
     */
    public function index(): JsonResponse
    {
        $menus = Menu::with(['page', 'children' => function ($query) {
            $query->orderBy('urutan');
        }])
            ->whereNull('parent_id')
            ->orderBy('urutan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $menus->map(function ($menu) {
                return $this->formatMenu($menu);
            })
        ]);
    }

    /**
     * Mendapatkan detail menu berdasarkan ID
     */
    public function show($id): JsonResponse
    {
        $menu = Menu::with(['page', 'parent', 'children'])->find($id);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatMenu($menu)
        ]);
    }

    /**
     * Format data menu
     */
    private function formatMenu($menu): array
    {
        $data = [
            'id' => $menu->id,
            'nama_menu' => $menu->nama_menu,
            'link_type' => $menu->link_type,
            'url_halaman' => $menu->url_halaman,
            'urutan' => $menu->urutan,
        ];

        if ($menu->page) {
            $data['page'] = [
                'id' => $menu->page->id,
                'judul' => $menu->page->judul,
                'url_halaman' => $menu->page->url_halaman,
            ];
        }
        if ($menu->parent) {
            $data['parent'] = [
                'id' => $menu->parent->id,
                'nama_menu' => $menu->parent->nama_menu,
            ];
        }

        if ($menu->children && $menu->children->isNotEmpty()) {
            $data['children'] = $menu->children->map(function ($child) {
                return $this->formatMenu($child);
            });
        }

        return $data;
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use App\Models\Berita;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    /**
     * Mapping type → model
     */
    private function resolveCommentable(string $type, int $id)
    {
        return match ($type) {
            'berita' => Berita::findOrFail($id),
            'pengumuman' => Pengumuman::findOrFail($id),
            default => abort(404, 'Tipe komentar tidak valid'),
        };
    }

    /**
     * GET komentar (approved only)
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'required|in:berita,pengumuman',
            'id'   => 'required|integer',
        ]);

        $model = $this->resolveCommentable($request->type, $request->id);

        return response()->json([
            'data' => $model->komentar()
                ->where('is_approved', true)
                ->latest()
                ->get(),
        ]);
    }

    /**
     * POST kirim komentar
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'         => 'required|in:berita,pengumuman',
            'id'           => 'required|integer',
            'nama'         => 'required|string|max:100',
            'email'        => 'required|email',
            'isi_komentar' => 'required|string',
        ]);

        $model = $this->resolveCommentable($request->type, $request->id);

        $komentar = $model->komentar()->create([
            'nama'         => $request->nama,
            'email'        => $request->email,
            'isi_komentar' => $request->isi_komentar,
            'is_approved'  => false,
        ]);

        return response()->json([
            'message' => 'Komentar berhasil dikirim dan menunggu moderasi',
            'data'    => $komentar,
        ], 201);
    }

    /**
     * ADMIN: balas & approve
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|string',
        ]);

        $komentar = Komentar::findOrFail($id);
        $komentar->update([
            'tanggapan' => $request->tanggapan,
            'is_approved' => true,
        ]);

        return response()->json([
            'message' => 'Komentar berhasil ditanggapi',
        ]);
    }
}

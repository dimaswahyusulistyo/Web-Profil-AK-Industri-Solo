<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'   => 'required|string',
            'layout'  => 'required|string',
            'konten'  => 'nullable',
        ]);

        $data['slug'] = Str::slug($request->judul);

        Page::create($data);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil dibuat');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'judul'  => 'required|string',
            'layout' => 'required|string',
            'konten' => 'nullable',
        ]);

        $data['slug'] = Str::slug($request->judul);

        $page->update($data);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil diperbarui');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Halaman dihapus');
    }
}

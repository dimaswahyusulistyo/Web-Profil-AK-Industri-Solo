<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = NewsCategory::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'category_id' => 'nullable',
        ]);

        $data['slug'] = Str::slug($request->judul);

        News::create($data);

        return redirect()->route('news.index')->with('success','Berita ditambahkan');
    }

    public function edit(News $news)
    {
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news','categories'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);
        $news->update($data);

        return redirect()->route('news.index')->with('success','Berita diperbarui');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return back()->with('success','Berita dihapus');
    }
}

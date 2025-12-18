<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('urutan')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')->get();
        $pages   = Page::all();
        return view('admin.menus.create', compact('parents','pages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_menu' => 'required',
            'tipe'      => 'required',
            'parent_id' => 'nullable',
            'target_id' => 'nullable',
            'url'       => 'nullable',
            'posisi'    => 'required',
            'urutan'    => 'nullable|integer',
        ]);

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::whereNull('parent_id')->where('id','!=',$menu->id)->get();
        $pages   = Page::all();
        return view('admin.menus.edit', compact('menu','parents','pages'));
    }

    public function update(Request $request, Menu $menu)
    {
        $menu->update($request->all());
        return redirect()->route('menus.index')->with('success', 'Menu diperbarui');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu dihapus');
    }
}

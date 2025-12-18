<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('urutan')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        Partner::create($request->all());
        return redirect()->route('partners.index')->with('success','Mitra ditambahkan');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $partner->update($request->all());
        return redirect()->route('partners.index')->with('success','Mitra diperbarui');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return back()->with('success','Mitra dihapus');
    }
}

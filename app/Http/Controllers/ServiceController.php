<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('urutan')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        Service::create($request->all());
        return redirect()->route('services.index')->with('success','Layanan ditambahkan');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($request->all());
        return redirect()->route('services.index')->with('success','Layanan diperbarui');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success','Layanan dihapus');
    }
}

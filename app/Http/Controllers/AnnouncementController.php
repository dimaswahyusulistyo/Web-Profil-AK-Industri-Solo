<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        Announcement::create($request->all());
        return redirect()->route('announcements.index')->with('success','Pengumuman ditambahkan');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $announcement->update($request->all());
        return redirect()->route('announcements.index')->with('success','Pengumuman diperbarui');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success','Pengumuman dihapus');
    }
}

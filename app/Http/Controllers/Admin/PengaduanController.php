<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan; // Pastikan model Pengaduan sudah ada
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = \App\Models\Pengaduan::orderBy('Id_Pengaduan', 'desc')->get(); 
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pengaduan = \App\Models\Pengaduan::findOrFail($id);
        $pengaduan->Keterangan = $request->status;
        $pengaduan->save();

        return back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }
}
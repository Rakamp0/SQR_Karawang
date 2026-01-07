<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan; 
use App\Models\Thread; 

class DashboardController extends Controller
{
    public function index()
    {
   
        $totalAduan = 0;
        $totalThread = 0;

        // Cek login sebagai dinas atau admin/petugas?
        // Kita cek satu-satu biar alurnya jelas
        if (Auth::guard('instansi')->check()) {
            
            // Jika login sebagai isntansi 
            $user_instansi = Auth::guard('instansi')->user();

            // Hitung aduan yang 'Id_Instansi'-nya sama 
            $totalAduan = Pengaduan::where('Id_Instansi', $user_instansi->Id_Instansi)->count();

        } elseif (Auth::guard('petugas')->check()) {
            
            // Jika login sebagai admin/petugas. Bisa lihat semua jumlah aduan
            $totalAduan = Pengaduan::count();
        }

        // Hitung Data Thread
        $totalThread = Thread::count();

        // Tampilkan di view
        return view('admin.dashboard', [
            'totalAduan'  => $totalAduan,
            'totalThread' => $totalThread
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Impor Model Anda di sini
use App\Models\Pengaduan; 
use App\Models\Thread; 

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah data dari tabel masing-masing
        $totalAduan = Pengaduan::count(); 
        $totalThread = Thread::count();

        // Mengirim data ke view admin.dashboard
        return view('admin.dashboard', compact('totalAduan', 'totalThread'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thread; 
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
    $threads = \App\Models\Thread::orderBy('Id_Thread', 'desc')->get();
    return view('admin.thread.index', compact('threads'));
    }

    public function destroy($id)
    {
        $thread = Thread::findOrFail($id);
        $thread->delete();
        return back()->with('success', 'Thread berhasil dihapus');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\HasilRegresi;

class KoefisieniController extends Controller
{
    public function index()
    {
        // Ambil semua data hasil regresi beserta relasi ke produk
        $data = HasilRegresi::with('produk')->get();

        return view('admin.koefisien', compact('data'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\HasilRegresi;
use App\Models\ProdukPenjualan;
class PrediksiController extends Controller
{
    public function index()
    {
        // Ambil semua data hasil prediksi dan relasi produk
        $data = HasilRegresi::with('produk')->get();

        return view('admin.hasil-prediksi', compact('data'));
    }
    public function show($id)
{
    $produk = ProdukPenjualan::findOrFail($id);
    $regresi = $produk->hasilRegresi;

    $aktual = [
        'Januari' => $produk->jan,
        'Februari' => $produk->feb,
        'Maret' => $produk->mar,
        'April' => $produk->apr,
        'Mei' => $produk->mei,
        'Juni' => $produk->jun,
    ];

    $prediksi = [
        'Juli' => $regresi->jul,
        'Agustus' => $regresi->agu,
        'September' => $regresi->sep,
        'Oktober' => $regresi->okt,
        'November' => $regresi->nov,
        'Desember' => $regresi->des,
    ];

    return view('admin.detail-produk', compact('produk', 'regresi', 'aktual', 'prediksi'));
}

}

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

        // Data aktual Jan–Jun
        $aktual = [
            'Januari'   => $produk->jan,
            'Februari'  => $produk->feb,
            'Maret'     => $produk->mar,
            'April'     => $produk->apr,
            'Mei'       => $produk->mei,
            'Juni'      => $produk->jun,
        ];

        // Data prediksi Jan–Des
        $prediksi = [
            'Januari'   => $regresi->jan,
            'Februari'  => $regresi->feb,
            'Maret'     => $regresi->mar,
            'April'     => $regresi->apr,
            'Mei'       => $regresi->mei,
            'Juni'      => $regresi->jun,
            'Juli'      => $regresi->jul,
            'Agustus'   => $regresi->agu,
            'September' => $regresi->sep,
            'Oktober'   => $regresi->okt,
            'November'  => $regresi->nov,
            'Desember'  => $regresi->des,
        ];

        // Hitung evaluasi MAPE (untuk data Jan–Jun)
        $evaluasi = [];
        $total_error = 0;
        $bulan_keys = array_keys($aktual);

        foreach ($bulan_keys as $i => $bulan) {
            $x = $i + 1;
            $y_aktual = $aktual[$bulan];
            $y_pred = $prediksi[$bulan];
            $selisih = $y_aktual - $y_pred;
            $error_percent = abs($selisih) / max($y_aktual, 1) * 100;
            $total_error += $error_percent;

            $evaluasi[] = [
                'x' => $x,
                'bulan' => $bulan,
                'aktual' => $y_aktual,
                'prediksi' => $y_pred,
                'selisih' => $selisih,
                'error_percent' => $error_percent,
            ];
        }

        $mape_manual = round($total_error / count($bulan_keys), 2);

        return view('admin.detail-produk', compact(
            'produk',
            'regresi',
            'aktual',
            'prediksi',
            'evaluasi',
            'mape_manual'
        ));
    }
}

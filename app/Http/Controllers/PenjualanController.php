<?php

namespace App\Http\Controllers;

use App\Models\ProdukPenjualan;
use App\Models\HasilRegresi;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = ProdukPenjualan::all();
        return view('admin.data-penjualan', compact('penjualan'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string',
            'harga_satuan' => 'required|integer',
            'jan' => 'required|integer',
            'feb' => 'required|integer',
            'mar' => 'required|integer',
            'apr' => 'required|integer',
            'mei' => 'required|integer',
            'jun' => 'required|integer',
        ]);

        // 1. Simpan data penjualan
        $produk = ProdukPenjualan::create($validated);

        // 2. Hitung regresi linier sederhana
        $x = [1, 2, 3, 4, 5, 6];
        $y = [
            $validated['jan'],
            $validated['feb'],
            $validated['mar'],
            $validated['apr'],
            $validated['mei'],
            $validated['jun'],
        ];

        $n = count($x);
        $sum_x = array_sum($x);
        $sum_y = array_sum($y);
        $sum_x2 = array_sum(array_map(fn($v) => $v * $v, $x));
        $sum_xy = array_sum(array_map(fn($x, $y) => $x * $y, $x, $y));

        $b = ($n * $sum_xy - $sum_x * $sum_y) / ($n * $sum_x2 - pow($sum_x, 2));
        $a = ($sum_y - $b * $sum_x) / $n;
        $persamaan = "Y = " . round($a, 2) . " + " . round($b, 2) . "X";

        // 3. Prediksi bulan Juli (X=7) hingga Desember (X=12)
        $prediksi = [];
        for ($i = 7; $i <= 12; $i++) {
            $prediksi[] = round($a + $b * $i);
        }

        // 4. Hitung MAPE (evaluasi akurasi)
        $total_error = 0;
        foreach ($x as $i => $xi) {
            $y_pred = $a + $b * $xi;
            $error = abs($y[$i] - $y_pred) / max($y[$i], 1); // hindari div 0
            $total_error += $error;
        }
        $mape = round(($total_error / $n) * 100, 2);

        // 5. Simpan ke hasil_regresis
        HasilRegresi::create([
            'produk_id' => $produk->id,
            'a' => $a,
            'b' => $b,
            'persamaan' => $persamaan,
            'mape' => $mape,
            'jul' => $prediksi[0],
            'agu' => $prediksi[1],
            'sep' => $prediksi[2],
            'okt' => $prediksi[3],
            'nov' => $prediksi[4],
            'des' => $prediksi[5],
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Data berhasil ditambahkan dan diproses.');
    }

    public function destroy($id)
    {
        ProdukPenjualan::destroy($id);
        return redirect()->route('penjualan.index')->with('success', 'Data berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string',
            'harga_satuan' => 'required|integer',
            'jan' => 'required|integer',
            'feb' => 'required|integer',
            'mar' => 'required|integer',
            'apr' => 'required|integer',
            'mei' => 'required|integer',
            'jun' => 'required|integer',
        ]);

        ProdukPenjualan::findOrFail($id)->update($validated);

        return redirect()->route('penjualan.index')->with('success', 'Data berhasil diperbarui.');
    }

}

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

        // simpan nilai asli a dan b tanpa dibulatkan ke dalam database
        $persamaan = "Y = " . round($a, 3) . " + " . round($b, 3) . "X";

        // 3. Prediksi bulan Jan–Des (X=1 s.d. 12)
        $prediksi = [];
        $prediksi_desimal = [];

        for ($i = 1; $i <= 12; $i++) {
            $nilai = $a + $b * $i;
            $prediksi[] = round($nilai); // untuk disimpan ke DB
            $prediksi_desimal[] = round($nilai, 3); // untuk MAPE
        }


        // 4. Hitung MAPE (evaluasi akurasi, pakai desimal)
        $total_error = 0;
        foreach ($x as $i => $xi) {
            $y_pred = $prediksi_desimal[$i]; // prediksi aslinya
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
            'jan' => $prediksi[0],
            'feb' => $prediksi[1],
            'mar' => $prediksi[2],
            'apr' => $prediksi[3],
            'mei' => $prediksi[4],
            'jun' => $prediksi[5],
            'jul' => $prediksi[6],
            'agu' => $prediksi[7],
            'sep' => $prediksi[8],
            'okt' => $prediksi[9],
            'nov' => $prediksi[10],
            'des' => $prediksi[11],
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

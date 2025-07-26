<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPenjualan extends Model
{
    use HasFactory;

    protected $table = 'produk_penjualans'; // Nama tabel di database

    protected $fillable = [
        'nama_produk',
        'harga_satuan',
        'jan',
        'feb',
        'mar',
        'apr',
        'mei',
        'jun',
    ];

    // Jika nanti ada relasi ke tabel hasil_regresi:
    public function hasilRegresi()
    {
        return $this->hasOne(HasilRegresi::class, 'produk_id');
    }
}

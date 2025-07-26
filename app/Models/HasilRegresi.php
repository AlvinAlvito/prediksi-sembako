<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilRegresi extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'a',
        'b',
        'persamaan',
        'mape',
        'jul',
        'agu',
        'sep',
        'okt',
        'nov',
        'des',
    ];

    // Relasi ke ProdukPenjualan
    public function produk()
    {
        return $this->belongsTo(ProdukPenjualan::class, 'produk_id');
    }
}

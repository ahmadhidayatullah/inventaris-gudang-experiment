<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'tanggal_transaksi',
        'jenis_transaksi',
        'barang_id',
        'jumlah'
    ];

    public function getBarang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_id', 'id');
    }


}


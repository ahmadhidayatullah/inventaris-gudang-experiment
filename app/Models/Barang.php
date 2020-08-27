<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'jenis_barang_id', 'nama','stock','gambar'
    ];

    public function getJenisBarang()
    {
        return $this->belongsTo('App\Models\JenisBarang', 'jenis_barang_id', 'id');
    }
}
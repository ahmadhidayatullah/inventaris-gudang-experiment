<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    private $folder = 'laporan';

    public function barangMasuk(Request $request)
    {
        $tanggal['mulai'] = $request->mulai.' 00:00:00';
        $tanggal['sampai'] = $request->sampai.' 23:59:59';

        $data = Transaksi::when($request->mulai, function ($query) use ($tanggal) {
            $query->whereBetween('tanggal_transaksi',[$tanggal['mulai'],$tanggal['sampai']]);
        })->where('jenis_transaksi','masuk')->paginate(10);

        $data->appends($request->all());

        return view($this->folder.'.masuk',[
            'data' => $data
        ]);

    }

    public function barangKeluar(Request $request)
    {
        $tanggal['mulai'] = $request->mulai.' 00:00:00';
        $tanggal['sampai'] = $request->sampai.' 23:59:59';

        $data = Transaksi::when($request->mulai, function ($query) use ($tanggal) {
            $query->whereBetween('tanggal_transaksi',[$tanggal['mulai'],$tanggal['sampai']]);
        })->where('jenis_transaksi','keluar')->paginate(10);

        $data->appends($request->all());

        return view($this->folder.'.keluar',[
            'data' => $data
        ]);

    }
}

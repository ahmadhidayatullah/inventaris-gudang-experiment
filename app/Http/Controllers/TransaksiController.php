<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Validator;
use Auth;

class TransaksiController extends Controller
{
    private $folder = 'transaksi';

    public function index(Request $request)
    {
        $data = Barang::when($request->q, function ($query) use ($request) {

            $query->where('nama', 'like', '%' . $request->q . '%');

        })->paginate(10);

        $data->appends($request->all());

        return view($this->folder.'.index',[
            'data' => $data
        ]);
    }

    public function tambahStok(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'total' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        \DB::beginTransaction();
        try {
            
            $data['masuk'] = Transaksi::create([
                'barang_id'   =>  $id,
                'jenis_transaksi'   => 'masuk',
                'tanggal_transaksi'   =>  $request->tanggal,
                'jumlah'   =>  $request->total,
            ]);

            $barang = Barang::findOrFail($id);

            $barang->stock = $barang->stock + $request->total;
            
            $data['update'] = $barang->save();
    
            if ($data) {
                \DB::commit();
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Berhasil menambahkan stok !', 'success'));
            }else{
                \DB::rollback();
                // dd((date('Y-m-d') . ": " . $e->getMessage() . "\n"));
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
            }
    

        } catch (\Exception $e) {
            \DB::rollback();
            // echo (date('Y-m-d') . ": " . $e->getMessage() . "\n");
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
        }
    }

    public function riwayatTambahStok(Request $request)
    {
        $data = Transaksi::when($request->q, function ($query) use ($request) {
            $query->whereHas('getBarang',function($query) use ($request){
                $query->where('nama', 'like', '%' . $request->q . '%');

            });

        })->where('jenis_transaksi','masuk')->paginate(10);

        $data->appends($request->all());

        return view($this->folder.'.riwayat-masuk',[
            'data' => $data
        ]);
    }

    public function stokKeluar(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        \DB::beginTransaction();
        try {
            
            $data['masuk'] = Transaksi::create([
                'barang_id'   =>  $id,
                'jenis_transaksi'   => 'keluar',
                'tanggal_transaksi'   =>  $request->tanggal,
                'jumlah'   =>  $request->total,
            ]);

            $barang = Barang::findOrFail($id);
            $count = $barang->stock - $request->total;
            if ($count < 0) {
                \DB::rollback();
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('stock tidak mencukupi !', 'danger'));
            } else {
                $barang->stock = $count;
            }
            
            $data['update'] = $barang->save();
    
            if ($data) {
                \DB::commit();
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Berhasil stok keluar !', 'success'));
            }else{
                \DB::rollback();
                // echo (date('Y-m-d') . ": " . 'anu' . "\n");
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
            }
    

        } catch (\Exception $e) {
            \DB::rollback();
            // echo (date('Y-m-d') . ": " . $e->getMessage() . "\n");
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
        }
    }

    public function riwayatStokKeluar(Request $request)
    {
        $data = Transaksi::when($request->q, function ($query) use ($request) {
            $query->whereHas('getBarang',function($query) use ($request){
                $query->where('nama', 'like', '%' . $request->q . '%');

            });

        })->where('jenis_transaksi','keluar')->paginate(10);

        $data->appends($request->all());

        return view($this->folder.'.riwayat-keluar',[
            'data' => $data
        ]);
    }

    public function destroyTambahStok(Request $request,$id)
    {
        \DB::beginTransaction();
        try {
            
            $history = Transaksi::findOrFail($id);

            $barang = Barang::findOrFail($history->barang_id);
            $barang->stock = $barang->stock - $history->jumlah;
            

            $data['update'] = $barang->save();
            $data['history'] = $history->delete();
    
            if ($data) {
                \DB::commit();
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Berhasil mengebalikan stok !', 'success'));
            }else{
                \DB::rollback();
                // echo (date('Y-m-d') . ": " . 'anu' . "\n");
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
            }
    

        } catch (\Exception $e) {
            \DB::rollback();
            // echo (date('Y-m-d') . ": " . $e->getMessage() . "\n");
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
        }
    }

    public function destroyStokKeluar(Request $request,$id)
    {
        \DB::beginTransaction();
        try {
            
            $history = Transaksi::findOrFail($id);

            $barang = Barang::findOrFail($history->barang_id);
            $barang->stock = $barang->stock + $history->jumlah;

            $data['update'] = $barang->save();
            $data['history'] = $history->delete();
    
            if ($data) {
                \DB::commit();
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Berhasil mengebalikan stok !', 'success'));
            }else{
                \DB::rollback();
                // echo (date('Y-m-d') . ": " . 'anu' . "\n");
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
            }
    

        } catch (\Exception $e) {
            \DB::rollback();
            // echo (date('Y-m-d') . ": " . $e->getMessage() . "\n");
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal menyimpan data. Koneksi Bermasalah!', 'danger'));
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\JenisBarang;
use Validator;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Barang::when($request->q, function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        })
        ->orderBy('id','DESC')->paginate(10);

        $data->appends($request->all());

        return view('barang.index',[
            'data'  =>  $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = JenisBarang::all();
        return view('barang.create',[
            'jenis' =>  $jenis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required",
            "jenis" => "required",
            'gambar' => 'required|file|mimes:jpeg,jpg,png|max:20000',
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        $link = $request->file('gambar');
        $ext = $link->extension();
        $name = uniqid();
        //uploading the original file for later use

        $link->move('uploads/', $name . '.'.$ext);
        $urlName = 'uploads/' . $name . '.'.$ext;

        $simpan = Barang::create([
            'jenis_barang_id' => $request->jenis,
            'nama' => $request->nama,
            'stock' => 0,
            'gambar' => $urlName
        ]);

        if ($simpan) {
            # code...
            return redirect()->route('barang')->with('message', \GeneralHelper::formatMessage('Berhasil menambahkan data !', 'success'));
        } else {
            return redirect()->route('barang')->with('message', \GeneralHelper::formatMessage('Gagal menambahkan data !', 'danger'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Barang::findOrFail($id);

        $jenis = JenisBarang::all();

        return view('barang.edit',[
            'data'  =>  $data,
            'jenis' =>  $jenis
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->gambar == '') {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'jenis' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                "nama" => "required",
                "jenis" => "required",
                'gambar' => 'required|file|mimes:jpeg,jpg,png|max:20000',
            ]);
        }

        
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        if ($request->gambar == '') {

            $simpan = Barang::where('id',$id)->update([
                'nama'   =>  ucwords($request->nama),
                'jenis_barang_id'   =>  $request->jenis
            ]);
        } else {

                
            $data = Barang::findOrFail($id);
    
            $link = $request->file('gambar');
            $ext = $link->extension();
            $name = uniqid();
            //uploading the original file for later use
    
            $link->move('uploads/', $name . '.'.$ext);
            $urlName = 'uploads/' . $name . '.'.$ext;
    
            @unlink(public_path($data->gambar));

            $simpan = Barang::where('id',$id)->update([
                'jenis_barang_id' => $request->jenis,
                'nama' => $request->nama,
                'gambar' => $urlName
            ]);
        }
        


        if ($simpan) {
            # code...
            return redirect()->route('barang')->with('message', \GeneralHelper::formatMessage('Berhasil mengedit data !', 'success'));
        } else {
            return redirect()->route('barang')->with('message', \GeneralHelper::formatMessage('Gagal mengedit data !', 'danger'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $data = Barang::find($id);
            @unlink(public_path($data->gambar));
            $data->delete();
            return redirect()->route('barang')->with('message', \GeneralHelper::formatMessage('Berhasil menghapus!', 'info'));

        } catch (\Illuminate\Database\QueryException $e) {
            // var_dump($e->errorInfo );
            return redirect()->route('barang')->with('message', \GeneralHelper::formatMessage('Data ini masih digunakan oleh data lain!', 'danger'));
        }
    }
}

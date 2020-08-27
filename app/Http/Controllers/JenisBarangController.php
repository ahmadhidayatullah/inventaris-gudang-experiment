<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBarang;
use Validator;
use Illuminate\Validation\Rule;

class JenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = JenisBarang::when($request->q, function ($query) use ($request) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        })
        ->orderBy('id','DESC')->paginate(10);

        $data->appends($request->all());

        return view('jenis-barang.index',[
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
        return view('jenis-barang.create');
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
            "nama" => "required|unique:jenis_barangs"
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        JenisBarang::create([
            'nama'   =>  ucwords($request->nama),
            'keterangan'   =>  $request->keterangan
        ]);

        return redirect()->route('jenis-barang')->with('message', \GeneralHelper::formatMessage('Berhasil menambahkan data !', 'success'));
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
        $data = JenisBarang::findOrFail($id);

        return view('jenis-barang.edit',[
            'data'  =>  $data
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
        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                Rule::unique('jenis_barangs')->ignore($id),
            ]
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        JenisBarang::where('id',$id)->update([
            'nama'   =>  ucwords($request->nama),
            'keterangan'   =>  $request->keterangan
        ]);

        return redirect()->route('jenis-barang')->with('message', \GeneralHelper::formatMessage('Berhasil mengedit data !', 'success'));
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
            JenisBarang::where('id', $id)->delete();
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Jenis Barang berhasil dihapus!', 'success'));

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Data masih digunakan!', 'danger'));
        } 
    }
}

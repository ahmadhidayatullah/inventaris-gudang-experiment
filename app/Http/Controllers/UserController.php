<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function changeStatus(Request $request,$id)
    {
        $cek = User::where('id',$id)->update([
            'active' => $request->status ? false:true
        ]);

        if ($cek) {
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Akun berhasil diaktifkan!', 'success'));
        }else{
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Gagal update data!', 'danger'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::when($request->q, function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->q . '%');

        })->orderBy('id','DESC')->paginate(10);

        $data->appends($request->all());

        return view('user.index',[
            'data'=>$data
        ]);
    }

    public function listOfNonaktif(Request $request)
    {
        $data = User::when($request->q, function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->q . '%');

        })->where([
            ['active', false],
            ['role_id','!=', 1]
            ])->orderBy('id','DESC')->paginate(10);

        $data->appends($request->all());

        return view('user.nonaktif',[
            'data'=>$data
        ]);
    }

    public function listOfAktif(Request $request)
    {
        $data = User::when($request->q, function ($query) use ($request) {

            $query->where('name', 'like', '%' . $request->q . '%');

        })->where([
            ['active', true],
            ['role_id','!=', 1]
            ])->orderBy('id','DESC')->paginate(10);

        $data->appends($request->all());

        return view('user.aktif',[
            'data'=>$data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $level = \App\Models\Role::where([
            ['id','!=', 1],
            ['id','!=', 4],
            ['id','!=', 6]
        ])->get();

        return view('user.create',[
            'level' =>  $level
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
            "level" => "required",
            "name" => "required",
            "email" => "required|unique:users",
            "password" => "required",
            "no_hp" => "required"
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        User::create([
            'role_id'   =>  $request->level,
            'name'   =>  $request->name,
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'no_hp'   =>  $request->no_hp,
            'active'   =>  true
        ]);

        return redirect()->route('user')->with('message', \GeneralHelper::formatMessage('Berhasil menambahkan data !', 'success'));
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
        if (Auth::user()->role_id == 3) {
            if (Auth::user()->id != $id) {
                return redirect()->back()->with('message', \GeneralHelper::formatMessage('Anda terindikasi melakukan kecurangan!', 'warning'));
            }
        }
        $level = \App\Models\Role::where('id','!=',1)->get();
        $data = User::findOrFail($id);

        return view('user.edit',[
            'level' =>  $level,
            'data'  => $data
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
            "name" => "required",
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            "no_hp" => "required"
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }
        $data = User::findOrFail($id);
        if(isset($request->level) && $request->level != 1){
            $data->role_id = $request->level;
        }
        $data->name = $request->name;
        $data->email = $request->email;
        if($request->password){
            $data->password = bcrypt($request->password);
        }
        $data->no_hp = $request->no_hp;

        $data->save();
        if (Auth::user()->role_id != 3) {
            return redirect()->route('user')->with('message', \GeneralHelper::formatMessage('Berhasil mengupdate data !', 'success'));
        }else{
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Berhasil mengupdate data !', 'success'));
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
        if ($id == 1) {
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('User ini tidak dapat dihapus. hubungi pengembang!', 'danger'));
        }

        try {
            User::where('id', $id)->delete();
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('User berhasil dihapus!', 'success'));

        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('message', \GeneralHelper::formatMessage('Data masih digunakan!', 'danger'));
        }        
        
    }

    public function daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|unique:users",
            "password" => "required",
            "no_hp" => "required"
        ]);
        

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', \GeneralHelper::formatMessage('Silahkan periksa inputan !', 'danger'));
        }

        User::create([
            'role_id'   =>  3,
            'name'   =>  $request->name,
            'email'   =>  $request->email,
            'password'   =>  bcrypt($request->password),
            'no_hp'   =>  $request->no_hp,
            'active'   =>  true
        ]);

        return redirect()->route('konfirmasi')->with('message', \GeneralHelper::formatMessage('Data anda berhasil tersimpan !', 'success'));
    }
}

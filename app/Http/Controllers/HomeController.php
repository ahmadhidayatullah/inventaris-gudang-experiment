<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaKursus;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $data = PesertaKursus::when($request->q, function ($query) use ($request) {
        //     $query->whereHas('getPeserta',function($query)use ($request){

        //         $query->where('nama', 'like', '%' . $request->q . '%');
        //     });

        // })->where([
        //     'is_done'    => 0,
        //     ])->orderBy('id','DESC')->paginate(10);

        // $data->appends($request->all());

        return view('home');
    }
}

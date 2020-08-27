@extends('layouts.app')

@section('content')
<section class="login_content">
  <a href="{{route('login')}}">
      <img src="{{asset('assets/images/sdit.png')}}" alt="">
  </a>
                <h1><b> PENDAFTARAN ONLINE</b></h1>
                <div class="alert alert-success">
                  <p>Data anda telah berhasil tersimpan. Silahkan melakukan <a href="{{route('login')}}">Login</a> untuk mengisi formulir pendaftaran.</p>
                </div>
      </section>
@endsection

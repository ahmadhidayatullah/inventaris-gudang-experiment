@extends('layouts.app')

@section('content')
<div class="animate form login_form">
  <section class="login_content">
    <img src="{{asset('assets/images/logo-tukang.png')}}" alt="" style="max-width:50%">

    <form method="POST" action="{{ route('login') }}">
    @csrf
      <h1><b> INVENTARIS GUDANG</b></h1>
      <p>Sistem Informasi Stock Barang.</p>
      @if(session('message')) {!!session('message')!!} @endif
      <div>
        <input id="email" type="email" placeholder="E-mail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>

      <div>
        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" />
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>

      <div>
        <button type="submit" class="btn btn-default submit">
            {{ __('Login') }}
        </button>
        {{-- <a class="reset_pass" href="#">Lost your password?</a> --}}
      </div>

      <div class="clearfix"></div>

      <div class="separator">
        
        {{-- <p class="change_link">Belum punya akun?
          <a href="{{route('daftar')}}" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i> Buat Akun </a>
        </p>
        <div class="clearfix"></div>
        <br /> --}}

        <div>
          <h4></i> INVENTARIS BARANG</h4>
          <p>© {{date('Y')}} All Rights Reserved. </p>
        </div>
      </div>
    </form>
  </section>
</div>
@endsection
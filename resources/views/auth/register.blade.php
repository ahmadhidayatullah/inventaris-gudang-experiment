@extends('layouts.app')

@section('content')
<section class="login_content">
        <img src="{{asset('assets/images/sdit.png')}}" alt="">
        <form method="POST" action="{{ route('daftar.submit') }}">
                @csrf
                <h1><b> PENDAFTARAN ONLINE</b></h1>
                <p>Silahkan melakukan login atau buat akun jika belum memiliki akun.</p>
                @if(session('message')) {!!session('message')!!} @endif
          <div>
            <input type="text" class="form-control" placeholder="Nama Lengkap" name="name" required />
            @if ($errors->has('name')) 
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
          </div>
          <div>
            <input type="email" class="form-control" placeholder="E-Mail" name="email" required />
            @if ($errors->has('email')) 
                <p class="text-danger">{{$errors->first('email')}}</p>
            @endif
          </div>
          <div>
            <input type="password" class="form-control" name="password" placeholder="Password" required />
            @if ($errors->has('password')) 
                <p class="text-danger">{{$errors->first('password')}}</p>
            @endif
          </div>
          <div>
            <input type="text" class="form-control" placeholder="Nomor Handphone" name="no_hp" required />
            @if ($errors->has('no_hp')) 
                <p class="text-danger">{{$errors->first('no_hp')}}</p>
            @endif
          </div>
          <div>
            <button type="submit" class="btn btn-default submit" href="">Daftar</button>
          </div>

          <div class="clearfix"></div>

          <div class="separator">
            <p class="change_link">Sudah memiliki akun ?
                    <a href="{{route('login')}}" class="btn btn-sm btn-success"><i class="fa fa-sign-in"></i> Login </a>
            </p>

            <div class="clearfix"></div>
            <br />

            <div>
                    <h4></i> SD IT ALMADINAH MAROS</h4>
                    <p>© {{date('Y')}} All Rights Reserved. </p>
                  </div>
          </div>
        </form>
      </section>
@endsection

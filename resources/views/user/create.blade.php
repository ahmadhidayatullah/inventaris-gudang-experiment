@extends('layouts.template')

@section('content')
    <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Data User <small>module user.</small></h3>
              </div>

              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form tambah data <small>untuk mendaftarkan user</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <form action="{{route('user.store')}}" method="POST" class="form-horizontal form-label-left">
                            @csrf
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="level">Level <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <select class="form-control col-md-10 col-xs-12 select2" id="level" name="level" required>
                                        <option value="">Pilih level..</option>
                                        @foreach ($level as $item)
                                          <option value="{{$item->id}}">{{$item->name}} {{$item->desc ? ' ('.$item->desc.')' : ''}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('level')) 
                                        <p class="text-danger">{{$errors->first('level')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="name">Nama Lengkap <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" id="name" required="required" class="form-control col-md-10 col-xs-12" name="name" value="{{old('name')}}">
                                    @if ($errors->has('name')) 
                                        <p class="text-danger">{{$errors->first('name')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="email">E-Mail <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="email" id="email" required="required" class="form-control col-md-10 col-xs-12" name="email" value="{{old('email')}}">
                                    @if ($errors->has('email')) 
                                        <p class="text-danger">{{$errors->first('email')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="password">Password <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="password" id="password" required="required" class="form-control col-md-10 col-xs-12" name="password" value="{{old('password')}}">
                                    @if ($errors->has('password')) 
                                        <p class="text-danger">{{$errors->first('password')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="no_hp">No. Hp <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" id="no_hp" required="required" class="form-control col-md-10 col-xs-12" name="no_hp" value="{{old('no_hp')}}">
                                    @if ($errors->has('no_hp')) 
                                        <p class="text-danger">{{$errors->first('no_hp')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        
                        <div class="ln_solid"></div>
                        <div class="form-group pull-right">
                            <div class="row">
                                <div class="col-md-12">
                                        <button class="btn btn-primary" type="reset">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- end form for validations -->

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
@endsection

@section('css')    
    <!-- Select2 -->
    <link href="{{asset('assets/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <!-- Switchery -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/axios.min.js')}}"></script>

    <script>

      
    </script>

    
@endsection
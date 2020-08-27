@extends('layouts.template')

@section('content')
    <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Barang <small>module barang.</small></h3>
              </div>

              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form edit data <small>untuk edit barang</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <form action="{{route('barang.update',$data->id)}}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="nama">Nama Barang <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" id="nama" required="required" class="form-control col-md-10 col-xs-12" name="nama" value="{{old('nama')? old('nama'): $data->nama}}">
                                    @if ($errors->has('nama')) 
                                        <p class="text-danger">{{$errors->first('nama')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="jenis">Jenis Barang <span class="required">*</span>
                                </label>
                                <div class="col-md-10">
                                    <select name="jenis" id="jenis" class="form-control">
                                      <option value="">Pilih Jenis Barang..</option>
                                      @foreach ($jenis as $item)
                                        <option value="{{$item->id}}" {{($item->id == $data->jenis_barang_id) ? 'selected':''}}>{{$item->nama}}</option>
                                      @endforeach
                                    </select>
                                    @if ($errors->has('jenis')) 
                                        <p class="text-danger">{{$errors->first('jenis')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-2" for="gambar">Gambar
                                </label>
                                <div class="col-md-10">
                                    <input type="file" id="gambar" class="form-control col-md-10 col-xs-12" name="gambar" value="{{old('gambar')}}">
                                    @if ($errors->has('gambar')) 
                                        <p class="text-danger">{{$errors->first('gambar')}}</p>
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
@extends('layouts.template')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
 

  <!-- top tiles -->
  <div class="row">
    
    <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <a href="{{route('transaksi.riwayat-masuk')}}">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-upload blue"></i>
          </div>
          <div class="count">
            Riwayat Masuk
          </div>
    
          {{-- <h3>ODP</h3> --}}
          <p>Lihat selengkapnya..</p>
        </div>
      </a>
    </div>
    <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <a href="{{route('transaksi.riwayat-keluar')}}">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-history green"></i>
          </div>
          <div class="count">
            Riwayat Keluar
          </div>
    
          {{-- <h3>Riwayat Pendistribusian</h3> --}}
          <p>Lihat selengkapnya..</p>
        </div>
      </a>
    </div>
  </div>
  <!-- /top tiles -->
  <div class="">
      <div class="page-title">
          <div class="title_left">
            <h3>Transaksi
              <small>module transaksi.</small>
            </h3>
          </div>

          <form action="" method="GET">

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" name="q" value="{{ empty($_GET['q']) ? '' : $_GET['q'] }}" class="form-control" placeholder="Nama ...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Cari!</button>
                    </span>
                  </div>
                </div>
              </div>
            </form>
        </div>

        <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Barang <small>list barang</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <table class="table table-hover">
                    @if(session('message')) {!!session('message')!!} @endif
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>Jenis</th>
                      <th>Stok</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php ($i = !empty($_GET['page']) ? (($_GET['page'] - 1) * (isset($_GET['s']) ? $_GET['s'] : 10)) + 1 : 1)@endphp
                    @foreach ($data as $key=>$item)
                        
                      <tr>
                          <th scope="row">{{$i++}}</th>
                          <td>{{$item->nama}}</td>
                          <td>{{$item->getJenisBarang->nama}}</td>
                          <td>{{$item->stock}}</td>
                          <td>
                              <div class="btn-group" data-toggle="tooltip" data-placement="bottom" title="Tambah Stok">
                                <button 
                                data-href="{{route('transaksi.masuk',$item->id)}}" 
                                data-toggle="modal" 
                                data-target="#tambah-stok" 
                                data-nama="{{$item->nama}}"
                                class="btn btn-xs btn-primary" >
                                  <i class="fa fa-upload"></i>
                                  Tambah Stok
                                </button>
                              </div>
                              <div class="btn-group" data-toggle="tooltip" data-placement="bottom" title="Stok Keluar">
                                <button 
                                data-href="{{route('transaksi.keluar',$item->id)}}" 
                                data-toggle="modal" 
                                data-target="#stok-keluar" 
                                data-nama = "{{$item->nama}}"
                                class="btn btn-xs btn-success" >
                                  <i class="fa fa-mail-forward"></i>
                                  Stok Keluar
                                </button>
                              </div>
                          </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="pull-left">

                  {{ $data->links('vendor.pagination.default') }}
                </div>

              </div>
            </div>
          </div>
    </div>
  </div>
    
    
</div>

{{-- tambah stok --}}
<div class="modal fade" id="tambah-stok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fa fa-upload"></i>
          Tambah Stok <b id="nama"></b>
        </h4>
      </div>

      <form action="" method="post" class="act-ok-stok">
      <div class="modal-body">
          <div class="form-group">
              <div class="row">
                  <label class="control-label col-md-2" for="">Tanggal <span class="required">*</span>
                  </label>
          
                  <div class="col-md-10">
                      <input type="date" name="tanggal" class="form-control input-tanggal" required>
                      @if ($errors->has('tanggal')) 
                          <p class="text-danger">{{$errors->first('tanggal')}}</p>
                      @endif
                  </div>
              </div>
          </div>
          <div class="form-group">
              <div class="row">
                  <label class="control-label col-md-2" for="">Total <span class="required">*</span>
                  </label>
          
                  <div class="col-md-10">
                      <input type="number" name="total" class="form-control input-total" placeholder="total tambahan" required>
                      <span class="green"> *tanpa titik</span>
                      @if ($errors->has('total')) 
                          <p class="text-danger">{{$errors->first('total')}}</p>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default inline" data-dismiss="modal">Batal</button>
          <input type="submit" name="submit_edit" value="Simpan" class="btn btn-success btn-ok"> {{ csrf_field() }}
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Distribusi --}}
<div class="modal fade" id="stok-keluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fa fa-upload"></i>
          Stok Keluar <b id="nama"></b>
        </h4>
      </div>

      <form action="" method="post" class="act-ok-stok-keluar">
      <div class="modal-body">
          
          <div class="form-group">
              <div class="row">
                  <label class="control-label col-md-2" for="">Tanggal <span class="required">*</span>
                  </label>
          
                  <div class="col-md-10">
                      <input type="date" name="tanggal" class="form-control input-tanggal" required>
                      @if ($errors->has('tanggal')) 
                          <p class="text-danger">{{$errors->first('tanggal')}}</p>
                      @endif
                  </div>
              </div>
          </div>
          <div class="form-group">
              <div class="row">
                  <label class="control-label col-md-2" for="">Total <span class="required">*</span>
                  </label>
          
                  <div class="col-md-10">
                      <input type="number" name="total" class="form-control input-total" placeholder="total tambahan" required>
                      <span class="green"> *tanpa titik</span>
                      @if ($errors->has('total')) 
                          <p class="text-danger">{{$errors->first('total')}}</p>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        
          {{-- <input type="hidden" class="input-status" name="status"> --}}
          <button type="button" class="btn btn-default inline" data-dismiss="modal">Batal</button>
          <input type="submit" name="submit_distribusi" value="Simpan" class="btn btn-success btn-ok"> {{ csrf_field() }}
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  $('#tambah-stok').on('show.bs.modal', function(e) {
    $(this).find('.act-ok-stok').attr('action', $(e.relatedTarget).data('href'));

    let nama = $(e.relatedTarget).data('nama');    
    
    $(this).find('#nama').text(nama);
  });

  $('#stok-keluar').on('show.bs.modal', function(e) {
    $(this).find('.act-ok-stok-keluar').attr('action', $(e.relatedTarget).data('href'));

    let nama = $(e.relatedTarget).data('nama');    
    
    $(this).find('#nama').text(nama);
  });
  

</script>
@endsection
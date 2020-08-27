@extends('layouts.template')

@section('content')
<div class="right_col" role="main">
  <div class="clearfix"></div>
 
  <div class="">
      <div class="page-title">
          <div class="title_left">
            <h3>Riwayat Stok Keluar
              <small>module riwayat stok keluar.
                  {{-- <a href="{{route('file.create')}}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Tambah data </a> --}}
              </small>
            </h3>
          </div>

          <form action="" method="GET">

            <div class="title_right">
                <div class="col-md-8 col-sm-8 col-xs-12 form-group pull-right ">
                  <div class="row">
                    <div class="col-md-5">
                        <label for="">Mulai</label>
                        <input type="date" class="form-control tanggal" value="{{ empty($_GET['mulai']) ? date('d-m-Y') : $_GET['mulai'] }}" name="mulai" required>
                    </div>
                    <div class="col-md-7">
                        <label for="">Sampai</label>
                      <div class="input-group">
                          <input type="date" name="sampai" class="form-control tanggal" value="{{ empty($_GET['sampai']) ? date('d-m-Y') : $_GET['sampai'] }}" required>
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Cari!</button>
                          </span>
                        </div>

                    </div>
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
                <h2>Riwayat Stok Keluar <small>list riwayat</small></h2>
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
                      <th>Total</th>
                      <th>Tanggal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php ($i = !empty($_GET['page']) ? (($_GET['page'] - 1) * (isset($_GET['s']) ? $_GET['s'] : 10)) + 1 : 1)
                    @foreach ($data as $key=>$item)
                        
                      <tr>
                          <th scope="row">{{$i++}}</th>
                          <td>{{$item->getBarang->nama}}</td>
                          <td>{{$item->jumlah}}</td>
                          <td>{{ date('d M Y',strtotime($item->tanggal_transaksi)) }}</td>
                          <td>
                              <div class="btn-group" data-toggle="tooltip" data-placement="bottom" title="Hapus/ Kembalikan stock">
                                <button 
                                data-href="{{route('transaksi.destroy-masuk',$item->id)}}" 
                                data-toggle="modal" 
                                data-target="#hapus-stok" 
                                data-nama="{{$item->getBarang->nama}}"
                                class="btn btn-xs btn-danger" >
                                  <i class="fa fa-trash"></i>
                                  Hapus/ Kembalikan stock
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

{{-- hapus stok --}}
<div class="modal fade" id="hapus-stok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fa fa-trash"></i>
          Hapus/ Kembalikan Stok <b id="nama"></b>
        </h4>
      </div>

      <form action="" method="post" class="act-ok-stok">
      <div class="modal-body">
          <p>Tindakan ini akan mempengaruhi stok yang ada pada gudang. 
            <br>Stok gudang akan <b>dikurangi sesuai total data</b> yang akan dihapus saat ini.
            <br>
            ingin melanjutkan ?</p>
      </div>
      <div class="modal-footer">
        
          <input type="hidden" name="_method" value="DELETE">
          <button type="button" class="btn btn-default inline" data-dismiss="modal">Batal</button>
          <input type="submit" name="submit_edit" value="Hapus" class="btn btn-danger btn-ok"> {{ csrf_field() }}
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  $('#hapus-stok').on('show.bs.modal', function(e) {
    $(this).find('.act-ok-stok').attr('action', $(e.relatedTarget).data('href'));

    let nama = $(e.relatedTarget).data('nama');    
    
    $(this).find('#nama').text(nama);
  });

</script>
@endsection
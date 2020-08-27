@extends('layouts.template')

@section('content')
<div class="right_col" role="main">
    <div class="">
      <div class="page-title">
          <div class="title_left">
            <h3>Semua Data Jenis Barang
              @if (Auth::user()->role_id == 1)
                  
              <small>
                <a href="{{route('jenis-barang.create')}}" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Tambah data </a>
              </small>
              @endif
            </h3>
          </div>

          <form action="" method="GET">

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" name="q" value="{{ empty($_GET['q']) ? '' : $_GET['q'] }}" class="form-control" placeholder="Nama...">
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
                <h2>List data jenis barang</h2>
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
                        <th>Keterangan</th>
                        @if (Auth::user()->role_id == 1)
                        <th>Aksi</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @php ($i = !empty($_GET['page']) ? (($_GET['page'] - 1) * (isset($_GET['s']) ? $_GET['s'] : 10)) + 1 : 1)
                      @foreach ($data as $key=>$item)
                          
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->keterangan}}</td>
                            @if (Auth::user()->role_id == 1)
                            <td>                                  
                                <a href="{{route('jenis-barang.edit',$item->id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>                                    
                                <a data-href="{{route('jenis-barang.destroy',$item->id)}}" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus </a>  
                            </td>
                            @endif
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

{{-- hapus program --}}
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin ingin menghapus jenis ini ?</p>
        </div>
        <div class="modal-footer">
          <form action="" method="post" class="act-ok">
            <button type="button" class="btn btn-default inline" data-dismiss="modal">Batal</button>
            <input type="submit" name="submit" value="Ya" class="btn btn-danger btn-ok"> {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('css')
    
@endsection

@section('js')
<script type="text/javascript">
  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.act-ok').attr('action', $(e.relatedTarget).data('href'));
  });

</script>
@endsection
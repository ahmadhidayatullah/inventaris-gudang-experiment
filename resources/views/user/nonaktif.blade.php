@extends('layouts.template')

@section('content')
<div class="right_col" role="main">
    <div class="">
      <div class="page-title">
          <div class="title_left">
            <h3>Data User
              <small>yang belum aktif.</small></h3>
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
                <h2>List data user yang belum aktif</h2>
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
                        <th>E-Mail</th>
                        <th>No Hp</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php ($i = !empty($_GET['page']) ? (($_GET['page'] - 1) * (isset($_GET['s']) ? $_GET['s'] : 10)) + 1 : 1)
                      @foreach ($data as $key=>$item)
                          
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->no_hp}}</td>
                            <td>{{$item->active ? 'Aktif' : 'Belum Aktif'}}</td>
                            <td>
                              <a data-href="{{route('user.change-status',$item->id)}}" data-status="{{$item->active}}" data-toggle="modal" data-target="#confirm-user" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Konfirmasi </a>
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
<div class="modal fade" id="confirm-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Aktifkan User ?</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin mengaktifkan akun ini ?</p>
      </div>
      <div class="modal-footer">
        <form action="" method="post" class="act-ok">
          <input type="hidden" class="input-status" name="status">
          <button type="button" class="btn btn-default inline" data-dismiss="modal">Batal</button>
          <input type="submit" name="submit" value="Ya" class="btn btn-success btn-ok"> {{ csrf_field() }}
          <input type="hidden" name="_method" value="PUT">
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
  $('#confirm-user').on('show.bs.modal', function(e) {
      $(this).find('.act-ok').attr('action', $(e.relatedTarget).data('href'));
      $(this).find('.act-ok .input-status').val($(e.relatedTarget).data('status'));
    });

</script>
@endsection
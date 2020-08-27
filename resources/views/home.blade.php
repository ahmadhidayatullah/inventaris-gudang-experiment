@extends('layouts.template')

@section('content')
<div class="right_col" role="main">
  @if (Auth::user()->role_id != 3)
      @include('home-admin')
  @else
  @include('home-wali')
  @endif
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
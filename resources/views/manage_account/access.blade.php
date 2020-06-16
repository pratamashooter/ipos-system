@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_account/access/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center row">
      <h4 class="page-title col-8">Hak Akses</h4>
      <div class="input-group big-search col-4 text-right">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="mdi mdi-magnify search-icon"></i>
          </div>
        </div>
        <input type="text" class="form-control form-control-lg mr-2" name="search" placeholder="Cari data">
      </div>
      <div class="dropdown small-search col-4 text-right" hidden="">
        <button class="btn btn-icons btn-inverse-primary btn-new shadow-sm mr-2" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="mdi mdi-magnify"></i>
        </button>
        <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuIconButton1">
          <div class="row">
            <div class="col-11">
              <input type="text" class="form-control" name="search" placeholder="Cari data">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
        	<div class="col-12 table-responsive">
        		<table class="table table-custom">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th class="text-center b-left">Kelola Akun</th>
                  <th class="text-center b-left">Kelola Barang</th>
                  <th class="text-center b-left">Transaksi</th>
                  <th class="text-center b-left">Kelola Laporan</th>
                </tr>
              </thead>
              <tbody>
                @foreach($access as $user)
              	<tr>
                  <td>
                    <span class="d-flex justify-content-start align-items-center">
                      <img src="{{ asset('pictures/' . $user->foto) }}">
                      <span class="ml-2">
                        <span class="d-block mb-1">{{ $user->nama }}</span>
                        <span class="txt-user-desc">{{ $user->role }} <i class="mdi mdi-checkbox-blank-circle dot"></i> {{ $user->email }}</span>
                      </span>
                    </span>
                  </td>
                  <td class="text-center b-left" data-access="kelola_akun" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
                    @if($user->kelola_akun == 1)
                    <div class="btn-checkbox btn-access">
                        <i class="mdi mdi-checkbox-marked"></i>
                    </div>
                    @else
                    <div class="btn-checkbox btn-non-access">
                        <i class="mdi mdi-checkbox-blank-outline"></i>
                    </div>
                    @endif
                  </td>
                  <td class="text-center b-left" data-access="kelola_barang" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
                    @if($user->kelola_barang == 1)
                    <div class="btn-checkbox btn-access">
                        <i class="mdi mdi-checkbox-marked"></i>
                    </div>
                    @else
                    <div class="btn-checkbox btn-non-access">
                        <i class="mdi mdi-checkbox-blank-outline"></i>
                    </div>
                    @endif
                  </td>
                  <td class="text-center b-left" data-access="transaksi" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
                    @if($user->transaksi == 1)
                    <div class="btn-checkbox btn-access">
                        <i class="mdi mdi-checkbox-marked"></i>
                    </div>
                    @else
                    <div class="btn-checkbox btn-non-access">
                        <i class="mdi mdi-checkbox-blank-outline"></i>
                    </div>
                    @endif
                  </td>
                  <td class="text-center b-left" data-access="kelola_laporan" data-user="{{ $user->user }}" data-role="{{ $user->role }}">
                    @if($user->kelola_laporan == 1)
                    <div class="btn-checkbox btn-access">
                        <i class="mdi mdi-checkbox-marked"></i>
                    </div>
                    @else
                    <div class="btn-checkbox btn-non-access">
                        <i class="mdi mdi-checkbox-blank-outline"></i>
                    </div>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/manage_account/access/script.js') }}"></script>
<script type="text/javascript">
  function refreshNav(){
    $.ajax({
      url: "{{ url('/access/sidebar') }}",
      method: "GET",
      success:function(data){
        $('#sidebar').html(data);
      }
    });
  }

  $(document).on('click', '.btn-checkbox', function(){
    var data_access = $(this).parent().attr('data-access');
    var data_user = $(this).parent().attr('data-user');
    var data_role = $(this).parent().attr('data-role');
    if(data_role == 'admin'){
      swal({
        title: "Apa anda yakin?",
        text: "Program menyarankan untuk tidak mengubah hak akses admin",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal("Sedang diproses....", {
            buttons: false,
            timer: 1000,
          });
          $.ajax({
            url: "{{ url('/access/change') }}/" + data_user + '/' + data_access,
            method: "GET",
            success:function(data_1){
              var my_account = "{{ auth()->user()->id }}";
              $.ajax({
                url: "{{ url('/access/check') }}/" + my_account,
                method: "GET",
                success:function(data_2){
                  if(data_2 == 'benar'){
                    $('tbody').html(data_1);
                    refreshNav();
                  }else{
                    window.open("{{ url('/dashboard') }}", "_self");
                  }
                }
              });
            }
          }); 
        }
      });
    }else{
      swal("Sedang diproses....", {
        buttons: false,
        timer: 1000,
      });
      $.ajax({
        url: "{{ url('/access/change') }}/" + data_user + '/' + data_access,
        method: "GET",
        success:function(data_1){
          var my_account = "{{ auth()->user()->id }}";
          $.ajax({
            url: "{{ url('/access/check') }}/" + my_account,
            method: "GET",
            success:function(data_2){
              if(data_2 == 'benar'){
                $('tbody').html(data_1);
                refreshNav();
              }else{
                window.open("{{ url('/dashboard') }}", "_self");
              }
            }
          });
        }
      });
    }
  });
</script>
@endsection
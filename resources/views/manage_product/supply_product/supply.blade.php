@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/supply_product/supply/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Riwayat Pasok</h4>
      <div class="d-flex justify-content-start">
        <a href="{{ url('/supply/statistics') }}" class="btn btn-icons btn-inverse-primary btn-filter shadow-sm ml-2">
          <i class="mdi mdi-poll"></i>
        </a>
        <div class="dropdown dropdown-search">
          <button class="btn btn-icons btn-inverse-primary btn-filter shadow-sm ml-2" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-magnify"></i>
          </button>
          <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuIconButton1">
            <div class="row">
              <div class="col-11">
                <input type="text" class="form-control" name="search" placeholder="Cari barang">
              </div>
            </div>
          </div>
        </div>
	      <a href="{{ url('/supply/new') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
	      	<i class="mdi mdi-plus"></i>
	      </a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
        	<div class="col-12">
            <ul class="list-date">
              @foreach($dates as $date)
              <li class="txt-light">{{ date('d M, Y', strtotime($date)) }}</li>
              @php
              $supplies = \App\Supply::whereDate('supplies.created_at', $date)
              ->select('supplies.*')
              ->latest()
              ->get();
              @endphp
              <div class="table-responsive">
                <table class="table table-custom">
                  <tr>
                    <th>Nama Barang</th>
                    <th>Kode Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Total</th>
                    <th>Pemasok</th>
                  </tr>
                  @foreach($supplies as $supply)
                  <tr>
                    <td class="td-1">
                      <span class="d-block font-weight-bold big-font">{{ $supply->nama_barang }}</span>
                      <span class="d-block mt-2 txt-light">{{ date('d M, Y', strtotime($supply->created_at)) . ' pada ' . date('H:i', strtotime($supply->created_at)) }}</span>
                    </td>
                    <td class="td-2 font-weight-bold">{{ $supply->kode_barang }}</td>
                    <td class="td-3 font-weight-bold"><span class="ammount-box bg-secondary"><i class="mdi mdi-cube-outline"></i></span>{{ $supply->jumlah }}</td>
                    <td class="font-weight-bold td-4"><input type="text" name="harga" value="{{ $supply->harga_beli }}" hidden=""><span class="ammount-box bg-green"><i class="mdi mdi-coin"></i></span>Rp. {{ number_format($supply->harga_beli,2,',','.') }}</td>
                    <td class="total-field font-weight-bold text-success"></td>
                    <td class="font-weight-bold">{{ $supply->pemasok }}</td>
                  </tr>
                  @endforeach
                </table>
              </div>
              @endforeach
            </ul>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/manage_product/supply_product/supply/script.js') }}"></script>
<script type="text/javascript">
  @if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('import_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif
</script>
@endsection
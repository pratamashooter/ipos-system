@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Dashboard</h4>
      <button class="setting-btn" data-toggle="modal" data-target="#pengaturanTokoModal">
        Pengaturan Toko
      </button>
    </div>
  </div>
</div>
<div class="row modal-group">
  <div class="modal fade" id="pengaturanTokoModal" tabindex="-1" role="dialog" aria-labelledby="pengaturanTokoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form name="market_form" action="{{ url('/market/update') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="pengaturanTokoModalLabel">Pengaturan Toko</h5>
            <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-12">
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-4 col-12 col-form-label font-weight-bold">Nama Toko</label>
                  <div class="col-lg-9 col-md-9 col-sm-8 col-12">
                    <input type="text" class="form-control" name="nama_toko" placeholder="Masukkan Nama Toko" value="{{ $market->nama_toko }}">
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-8 col-12 offset-lg-3 offset-md-3 offset-sm-4 error-notice" id="nama_toko_error"></div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-4 col-12 col-form-label font-weight-bold">No Telepon</label>
                  <div class="col-lg-9 col-md-9 col-sm-8 col-12">
                    <input type="text" class="form-control" name="no_telp" placeholder="Masukkan No Telepon" value="{{ $market->no_telp }}">
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-8 col-12 offset-lg-3 offset-md-3 offset-sm-4 error-notice" id="no_telp_error"></div>
                </div>
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-4 col-12 col-form-label font-weight-bold">Alamat</label>
                  <div class="col-lg-9 col-md-9 col-sm-8 col-12">
                    <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan Alamat">{{ $market->alamat }}</textarea>
                  </div>
                  <div class="col-lg-9 col-md-9 col-sm-8 col-12 offset-lg-3 offset-md-3 offset-sm-4 error-notice" id="alamat_error"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-simpan"><i class="mdi mdi-content-save"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-sm-6 col-12 mb-4">
        <div class="card b-radius card-noborder bg-blue">
          <div class="card-body custom-card-p">
            <div class="row">
              <div class="col-12 d-flex justify-content-start align-items-center icon-card">
                <div class="icon-round text-white">
                  Rp
                </div>
                <div class="ml-3">
                  <p class="m-0 text-white">Pemasukan Harian</p>
                  <h5 class="text-white">{{ number_format($incomes_daily,2,',','.') }}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-6 col-12 mb-4">
        <div class="card b-radius card-noborder">
          <div class="card-body custom-card-p">
            <div class="row">
              <div class="col-12 d-flex justify-content-start align-items-center icon-card">
                <div class="icon-round-2">
                  <i class="mdi mdi-account-multiple"></i>
                </div>
                <div class="ml-3">
                  <p class="m-0">Pelanggan Harian</p>
                  <h5>{{ $customers_daily }} Orang</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
        <div class="card b-radius card-noborder">
          <div class="card-body">
            <div class="row">
              <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-semibold chart-title">Pemasukan 1 Minggu Terakhir</h5>
                <div class="dropdown">
                  <button class="btn btn-filter-chart icon-btn dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pemasukan
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                    <a class="dropdown-item chart-filter" href="#" data-filter="pemasukan">Pemasukan</a>
                    <a class="dropdown-item chart-filter" href="#" data-filter="pelanggan">Pelanggan</a>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <canvas id="myChart" style="width: 100%; height: 315px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="card b-radius card-noborder">
      <div class="card-body">
        <div class="row">
          <div class="col-12 text-center">
            <p class="m-0">Total Pemasukan</p>
            <h2 class="font-weight-bold">Rp. {{ number_format($all_incomes,2,',','.') }}</h2>
            <p class="m-0 txt-light">{{ date('d M, Y', strtotime($min_date)) }} - {{ date('d M, Y', strtotime($max_date)) }}</p>
          </div>
          <div class="col-12 text-center mt-4">
            <div class="btn-view-all">
              <i class="mdi mdi-chevron-down"></i>
            </div>
          </div>
          <div class="col-12">
            <hr>
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="font-weight-semibold">Riwayat Transaksi</h5>
              @php
              $access = \App\Acces::where('user', auth()->user()->id)
              ->first();
              @endphp
              <button class="btn btn-view-transaction" type="button" data-access="{{ $access->kelola_laporan }}">Semua</button>
            </div>  
          </div>
          <div class="col-12">
            @foreach($kd_transaction as $transaksi)
            @php
            $ket_transaksi = \App\Transaction::where('kode_transaksi', $transaksi->kode_transaksi)
            ->first();
            @endphp
            <div class="text-group mt-3">
              <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                  <span class="icon-transaksi">
                    <i class="mdi mdi-swap-horizontal"></i>
                  </span>
                  <div class="ml-2">
                    <p class="kode_transaksi font-weight-semibold">{{ $transaksi->kode_transaksi }}</p>
                    <p class="des-transaksi">Rp. {{ number_format($ket_transaksi->total,2,',','.') }} <span class="dot"><i class="mdi mdi-checkbox-blank-circle"></i></span> {{ $ket_transaksi->kasir }}</p>
                  </div>
                </div>
                <span class="w-transaksi">{{ Carbon\Carbon::parse($ket_transaksi->created_at)->diffForHumans()}}</span>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/dashboard/script.js') }}"></script>
<script src="{{ asset('plugins/js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/js/ChartRadius.js') }}"></script>
<script type="text/javascript">
@if ($message = Session::get('update_success'))
  swal(
      "Berhasil!",
      "{{ $message }}",
      "success"
  );
@endif
  
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
        @if(count($incomes) != 0)
        @foreach($incomes as $income)
        "{{ date('d M, Y', strtotime($income)) }}",
        @endforeach
        @endif
        ],
        datasets: [{
            label: '',
            data: [
            @if(count($incomes) != 0)
            @foreach($incomes as $income)
            @php
            $total = \App\Transaction::whereDate('created_at', $income)
            ->sum('total');
            @endphp
            "{{ $total }}",
            @endforeach
            @endif
            ],
            backgroundColor: 'RGB(44, 77, 240)',
            borderColor: 'RGB(44, 77, 240)',
            borderWidth: 0
        }]
    },
    options: {
        title: {
            display: false,
            text: ''
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                      if (parseInt(value) >= 1000) {
                         return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                      } else {
                         return 'Rp. ' + value;
                      }
                   }
                }
            }],
            xAxes: [{
                barPercentage: 0.2
            }]
        },
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
               label: function(tooltipItem) {
                      return tooltipItem.yLabel;
               }
            }
        }
    }
});

$(document).on('click', '.chart-filter', function(e){
  e.preventDefault();
  var data_filter = $(this).attr('data-filter');
  if(data_filter == 'pemasukan'){
    $('.btn-filter-chart').html('Pemasukan');
    $('.chart-title').html('Pemasukan 1 Minggu Terakhir');
  }else if(data_filter == 'pelanggan'){
    $('.btn-filter-chart').html('Pelanggan');
    $('.chart-title').html('Pelanggan 1 Minggu Terakhir');
  }
  $.ajax({
    url: "{{ url('/dashboard/chart') }}/" + data_filter,
    method: "GET",
    success:function(response){
      if(data_filter == 'pemasukan'){
        if(response.incomes.length != 0){
          changeDataPemasukan(myChart, response.incomes, response.total);
        }
      }else if(data_filter == 'pelanggan'){
        if(response.customers.length != 0){
          changeDataPelanggan(myChart, response.customers, response.jumlah);
        }
      }
    }
  });
});

$(document).on('click', '.btn-view-transaction', function(){
  var check_access = $(this).attr('data-access');
  if(check_access == 1){
    window.open("{{ url('/report/transaction') }}", "_self");
  }else{
    swal(
        "",
        "Maaf anda tidak memiliki akses",
        "error"
    );
  }
});
</script>
@endsection
@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/supply_product/statistics_supply/style.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/css/datedropper.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <div class="quick-link-wrapper d-md-flex flex-md-wrap">
        <ul class="quick-links">
          <li><a href="{{ url('supply') }}">Riwayat Pasok</a></li>
          <li><a href="{{ url('supply/statistics') }}">Statistik Pasok</a></li>
        </ul>
      </div>
      <div class="print-btn-group">
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="mdi mdi-export print-icon"></i>
            </div>
            <button class="btn btn-print" type="button" data-toggle="modal" data-target="#cetakModal">Export Laporan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="cetakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cetakModalLabel">Export Laporan</h5>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('/supply/statistics/export') }}" name="export_form" method="POST" target="_blank">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="form-group row">
                  <div class="col-5 border rounded-left offset-col-1">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jns_laporan" value="period" checked> Periode</label>
                    </div>
                  </div>
                  <div class="col-5 border rounded-right">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jns_laporan" value="manual"> Manual</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 period-form">
                <div class="form-group row">
                  <div class="col-10 p-0 offset-col-1">
                    <p>Pilih waktu dan periode</p>
                  </div>
                  <div class="col-4 p-0 offset-col-1">
                    <input type="number" class="form-control form-control-lg time-input number-input dis-backspace input-notzero" name="time" value="1" min="1" max="4">
                  </div>
                  <div class="col-6 p-0">
                    <select class="form-control form-control-lg period-select" name="period">
                      <option value="minggu" selected="">Minggu</option>
                      <option value="bulan">Bulan</option>
                      <option value="tahun">Tahun</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12 manual-form" hidden="">
                <div class="form-group row">
                  <div class="col-10 p-0 offset-col-1">
                    <p>Pilih tanggal awal dan akhir</p>
                  </div>
                  <div class="col-10 p-0 offset-col-1 input-group mb-2">
                    <input type="text" name="tgl_awal_export" class="form-control form-control-lg date" placeholder="Tanggal awal">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <i class="mdi mdi-calendar calendar-icon"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-10 p-0 offset-col-1 input-group">
                    <input type="text" name="tgl_akhir_export" class="form-control form-control-lg date" placeholder="Tanggal akhir">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <i class="mdi mdi-calendar calendar-icon"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-export">Export</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="tableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tableModalLabel">Daftar Barang</h5>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Cari barang">
              </div>  
            </div>
            <div class="col-12">
              <ul class="list-group product-list">
                @foreach($products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center active-list">
                  <div class="text-group">
                    <p class="m-0">{{ $product->kode_barang }}</p>
                    <p class="m-0 txt-light">{{ $product->nama_barang }}</p>
                  </div>
                  <div class="d-flex align-items-center">
                    <span class="ammount-box-1 bg-secondary mr-1"><i class="mdi mdi-cube-outline"></i></span>
                    <p class="m-0">{{ $product->stok }}</p>
                  </div>
                  <a href="#" class="btn btn-icons btn-rounded btn-inverse-outline-primary font-weight-bold btn-pilih" role="button"><i class="mdi mdi-chevron-right"></i></a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <p class="font-weight-bold">Diagram Kenaikan dan Penurunan</p>
          </div>
          <div class="col-12 mt-4">
            <canvas id="myChart" style="width: 100%; height: 350px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <form>
              <div class="form-group row">
                <div class="col-lg-8 col-md-8 col-sm-9 col-9">
                  <input type="text" class="form-control" name="kode_barang" value="{{ $products->first()->kode_barang }}" readonly="">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-3 btn-search-lg" hidden="">
                  <button class="btn btn-search btn-block font-weight-bold" data-toggle="modal" data-target="#tableModal" type="button">
                    <i class="mdi mdi-magnify"></i> Cari Barang
                  </button>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-3 btn-search-sm">
                  <button class="btn btn-search btn-block font-weight-bold" data-toggle="modal" data-target="#tableModal" type="button">
                    <i class="mdi mdi-magnify"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-12">
            <div class="row">
              <div class="col-12 d-flex justify-content-start align-items-center info-barang-group">
                <p class="mr-3 p-info-barang info-nama-barang">{{ $products->first()->nama_barang }}</p>
                <span class="dot mr-3"><i class="mdi mdi-checkbox-blank-circle"></i></span>
                <span class="ammount-box-3 mr-1"><i class="mdi mdi-cube-outline"></i></span>
                <p class="p-info-barang mr-3 info-stok-barang">{{ $products->first()->stok }}</p>
                <span class="dot mr-3"><i class="mdi mdi-checkbox-blank-circle"></i></span>
                @php
                $total_pemasok = \App\Supply::select('id_pemasok')
                ->where('kode_barang', '=', $products->first()->kode_barang)
                ->distinct()
                ->get();
                @endphp
                <p class="p-info-barang p-sisa">{{ $total_pemasok->count() }} Pemasok</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <ul class="percent-info font-weight-bold d-flex justify-content-start">
                  <li class="mr-4"><i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i> Penurunan Harga</li>
                  <li><i class="mdi mdi-checkbox-blank-circle mr-2 text-danger"></i> Kenaikan Harga</li>
                </ul>
              </div>
            </div>
          </div>
        	<div class="col-12 table-responsive">
            <table class="table table-custom">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Pemasok</th>
                  <th>Harga Satuan</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @php
                $supplies = \App\Supply::where('kode_barang', '=', $products->first()->kode_barang)
                ->select('supplies.*')
                ->orderBy('created_at', 'DESC')
                ->get();
                @endphp
                @foreach($supplies as $supply)
                <tr>
                  <td data-toggle="tooltip" data-placement="top" title="{{ date('d M, Y', strtotime($supply->created_at)). ' pada ' . date('h:m', strtotime($supply->created_at)) }}">{{ date('d M, Y', strtotime($supply->created_at)) }}</td>
                  <td>{{ $supply->pemasok }}</td>
                  <td>
                    <input type="text" name="harga_beli" hidden="" value="{{ $supply->harga_beli }}">
                    <span class="ammount-box-2 bg-green"><i class="mdi mdi-coin"></i></span>Rp. {{ number_format($supply->harga_beli,2,',','.') }}</td>
                  <td class="percent-status"></td>
                  <td>
                    <a role="button" href="#" class="ammount-box-2 bg-secondary info-btn" data-container="body" data-toggle="popover" data-placement="left" data-content="">
                      <i class="mdi mdi-information-outline"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
                <tr hidden="">
                  <td></td>
                  <td></td>
                  <td><input type="text" name="harga_beli" value="0"></td>
                  <td class="percent-status"></td>
                  <td></td>
                </tr>
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
<script src="{{ asset('plugins/js/datedropper.js') }}"></script>
<script src="{{ asset('plugins/js/Chart.min.js') }}"></script>
<script src="{{ asset('js/manage_product/supply_product/statistics_supply/script.js') }}"></script>
<script type="text/javascript">
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
        @foreach($supplies->reverse()->take(7) as $supply)
        "{{ date('d M, Y', strtotime($supply->created_at)) }}",
        @endforeach
        ],
        datasets: [{
            label: '',
            data: [
            @foreach($supplies->reverse()->take(7) as $supply)
            '{{ $supply->harga_beli }}',
            @endforeach
            ],
            backgroundColor: 'RGB(211, 234, 252)',
            borderColor: 'RGB(44, 77, 240)',
            borderWidth: 3
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
                    beginAtZero: false,
                    callback: function(value, index, values) {
                      if (parseInt(value) >= 1000) {
                         return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                      } else {
                         return 'Rp. ' + value;
                      }
                   }
                }
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

function changeData(chart, label_array, data_array){
  chart.data = {
      labels: label_array,
      datasets: [{
          label: '',
          data: data_array,
          backgroundColor: 'RGB(211, 234, 252)',
          borderColor: 'RGB(44, 77, 240)',
          borderWidth: 3
      }]
  }
  chart.update();
}

$(document).on('click', '.btn-pilih', function(e){
  e.preventDefault();
  var kode_barang = $(this).prev().prev().children().first().text();
  $.ajax({
    url: "{{ url('/supply/statistics/product') }}/" + kode_barang,
    method: "GET",
    success:function(response){
      $('.close-btn').click();
      $('input[name=kode_barang]').val(response.product.kode_barang);
      $('.info-nama-barang').html(response.product.nama_barang);
      $('.info-stok-barang').html(response.product.stok);
      changeData(myChart, response.dates, response.ammounts);
      $.ajax({
        url: "{{ url('/supply/statistics/users') }}/" + kode_barang,
        method: "GET",
        success:function(data){
          $('.p-sisa').html(data);
          $.ajax({
            url: "{{ url('/supply/statistics/table') }}/" + kode_barang,
            method: "GET",
            success:function(data){
              $('tbody').html(data);
              percentate();
              $("[data-toggle=popover]").popover();
            }
          });
        }
      });
    }
  });
});
</script>
@endsection
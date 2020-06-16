@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/supply_product/new_supply/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-start align-items-center">
      <div class="quick-link-wrapper d-md-flex flex-md-wrap">
        <ul class="quick-links">
          <li><a href="{{ url('supply') }}">Riwayat Pasok</a></li>
          <li><a href="{{ url('supply/new') }}">Pasok Barang</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="row modal-group">
  <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="scanModalLabel">Scan Barcode</h5>
	        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	          <div class="row">
	          	<div class="col-12 text-center" id="area-scan">
	          	</div>
	          	<div class="col-12 barcode-result" hidden="">
	          		<h5 class="font-weight-bold">Hasil</h5>
	          		<div class="form-border">
	          			<p class="barcode-result-text"></p>
	          		</div>
	          	</div>
	          </div>
	      </div>
	      <div class="modal-footer" id="btn-scan-action" hidden="">
	        <button type="button" class="btn btn-primary btn-sm font-weight-bold rounded-0 btn-continue">Lanjutkan</button>
	        <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold rounded-0 btn-repeat">Ulangi</button>
	      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="formatModal" tabindex="-1" role="dialog" aria-labelledby="formatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
	        <h5 class="modal-title" id="formatModalLabel">Format Upload</h5>
	        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	    	<div class="row">
	    		<div class="col-12 img-import-area">
	    			<img src="{{ asset('images/instructions/ImportSupply.jpg') }}" class="img-import">
	    		</div>
	    	</div>
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
					    	<span class="ammount-box bg-secondary mr-1"><i class="mdi mdi-cube-outline"></i></span>
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
	<div class="col-lg-4 col-md-12 col-sm-12 mb-4">
		<div class="row">
			<div class="col-12">
				<div class="card card-noborder b-radius">
					<div class="card-body">
						<div class="row">
							<div class="col-12 d-flex">
								<button class="btn-tab manual_form_btn btn-tab-active">Manual</button>
								<button class="btn-tab import_form_btn">Import</button>
								<div class="btn-tab-underline"></div>
							</div>
							<div class="col-12 mt-3">
								<form method="post" name="manual_form">
									<div class="form-group row">
										<label class="col-12 font-weight-bold col-form-label">Kode Barang</label>
										<div class="col-8">
											<input type="text" class="form-control" name="kode_barang" readonly="">
										</div>
										<div class="col-4 left-min d-flex">
											<div class="btn-group">
												<button class="btn btn-search" data-toggle="modal" data-target="#tableModal" type="button">
													<i class="mdi mdi-magnify"></i>
												</button>
												<button class="btn btn-scan" data-toggle="modal" data-target="#scanModal" type="button">
													<i class="mdi mdi-crop-free"></i>
												</button>
											</div>
										</div>
										<div class="col-12 error-notice" id="kode_barang_error"></div>
									</div>
									<div class="form-group row top-min">
										<label class="col-12 font-weight-bold col-form-label">Jumlah Barang</label>
										<div class="col-12">
											<input type="text" class="form-control number-input input-notzero" name="jumlah" placeholder="Masukkan Jumlah">
										</div>
										<div class="col-12 error-notice" id="jumlah_error"></div>
									</div>
									<div class="form-group row top-min">
										<label class="col-12 font-weight-bold col-form-label">Harga Satuan</label>
										<div class="col-12">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Rp.</div>
												</div>
												<input type="text" class="form-control number-input input-notzero" name="harga_beli" placeholder="Masukkan Harga Satuan">
											</div>
										</div>
										<div class="col-12 error-notice" id="harga_beli_error"></div>
									</div>
									<div class="row">
										<div class="col-12 d-flex justify-content-end">
											<button class="btn font-weight-bold btn-tambah" type="button">Tambah</button>
										</div>
									</div>
								</form>
								<form action="{{ url('/supply/import') }}" method="post" name="import_form" enctype="multipart/form-data" hidden="">
									@csrf
									<div class="d-flex justify-content-between pb-2 align-items-center">
					                  <h2 class="font-weight-semibold mb-0">Import</h2>
					                  <input type="file" name="excel_file" hidden="" accept=".xls, .xlsx">
					                  <a href="#" class="excel-file">
					                  	<div class="icon-holder">
						                   <i class="mdi mdi-upload"></i>
						                </div>
					                  </a>
					                </div>
					                <div class="d-flex justify-content-between">
					                  <h5 class="font-weight-semibold mb-0">Upload file excel</h5>
					                  <p class="excel-name">Pilih File</p>
					                </div>
					                <button class="btn btn-block mt-3 btn-upload" type="submit" hidden="">Import Data</button>
					                <div class="row mt-4">
					                	<div class="col-12">
					                		<h4 class="card-title mb-1">Langkah - Langkah Import</h4>
						                    <div class="d-flex py-2 border-bottom">
						                      <div class="wrapper">
						                        <p class="font-weight-semibold text-gray mb-0">1. Siapkan data dengan format Excel (.xls atau .xlsx)</p>
						                        <small class="text-muted">
						                        	<a href="" role="button" class="link-how" data-toggle="modal" data-target="#formatModal">Selengkapnya</a>
						                    	</small>
						                      </div>
						                    </div>
						                    <div class="d-flex py-2 border-bottom">
						                      <div class="wrapper">
						                        <p class="font-weight-semibold text-gray mb-0">2. Jika sudah sesuai pilih file</p>
						                      </div>
						                    </div>
						                    <div class="d-flex py-2">
						                      <div class="wrapper">
						                        <p class="font-weight-semibold text-gray mb-0">3. Klik simpan, maka data otomatis tersimpan</p>
						                      </div>
						                    </div>
					                	</div>
					                </div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-12 col-sm-12">
		<div class="card card-noborder b-radius">
			<div class="card-body">
				<form action="{{ url('/supply/create') }}" method="post">
					@csrf
					<div class="row">
						<div class="col-12 table-responsive mb-4">
							<table class="table table-custom">
								<thead>
									<tr>
										<th>Barang</th>
										<th>Jumlah</th>
										<th>Harga Satuan</th>
										<th>Total</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
						<div class="col-12 d-flex justify-content-end">
							<button class="btn btn-simpan btn-sm" type="submit" hidden=""><i class="mdi mdi-content-save"></i> Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/js/quagga.min.js') }}"></script>
<script src="{{ asset('js/manage_product/supply_product/new_supply/script.js') }}"></script>
<script type="text/javascript">
	@if ($message = Session::get('import_failed'))
		swal(
		    "",
		    "{{ $message }}",
		    "error"
		);
	@endif

	$(document).on('click', '.btn-continue', function(){
	  var kode_barang = $('.barcode-result-text').text();
	  $.ajax({
	  	url: "{{ url('/supply/check') }}/" + kode_barang,
	  	method: "GET",
	  	success:function(data){
	  		if(data == 'sukses'){
				$('input[name=kode_barang]').val(kode_barang);
				$('#btn-scan-action').prop('hidden', true);
				$('#area-scan').prop('hidden', true);
				$('.barcode-result').prop('hidden', true);
				$('.close-btn').click();
				$('input[name=kode_barang]').valid();
				stopScan();
	  		}else{
	  			swal(
			        "",
			        "Kode barang tidak tersedia",
			        "error"
			    );
	  		}
	  	}
	  });
	});

	$(document).on('click', '.btn-tambah', function(e){
		e.preventDefault();
		$('form[name=manual_form]').valid();
		var kode_barang = $('input[name=kode_barang]').val();
		var jumlah = $('input[name=jumlah]').val();
		var harga_beli = $('input[name=harga_beli]').val();
		var total = parseInt(jumlah) * parseInt(harga_beli);
		if(validator.valid() == true){
			$.ajax({
				url: "{{ url('/supply/data') }}/" + kode_barang,
				method: "GET",
				success:function(response){
					var check = $('.kd-barang-field:contains('+ response.product.kode_barang +')').length;
					if(check == 0){
						$('input[name=kode_barang]').val('');
						$('input[name=jumlah]').val('');
						$('input[name=harga_beli]').val('');
						$('tbody').append('<tr><td><span class="kd-barang-field">'+ response.product.kode_barang +'</span><span class="nama-barang-field">'+ response.product.nama_barang +'</span></td><td>'+ jumlah +'</td><td>Rp. '+ parseInt(harga_beli).toLocaleString() +'</td><td class="text-success">Rp. '+ parseInt(total).toLocaleString() +'</td><td><button type="button" class="btn btn-icons btn-rounded btn-secondary ml-1 btn-delete"><i class="mdi mdi-close"></i></button><div class="form-group" hidden=""><input type="text" class="form-control" name="kode_barang_supply[]" value="'+ response.product.kode_barang +'"><input type="text" class="form-control" name="jumlah_supply[]" value="'+ jumlah +'"><input type="text" class="form-control" name="harga_beli_supply[]" value="'+ harga_beli +'"></div></td></tr>');
						$('.btn-simpan').prop('hidden', false);
					}else{
						swal(
					        "",
					        "Barang telah ditambahkan",
					        "error"
					    );
					}
				}
			});
		}
	});
</script>
@endsection
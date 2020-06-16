@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/new_product/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-start align-items-center">
      <div class="quick-link-wrapper d-md-flex flex-md-wrap">
        <ul class="quick-links">
          <li><a href="{{ url('product') }}">Daftar Barang</a></li>
          <li><a href="{{ url('product/new') }}">Barang Baru</a></li>
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
	    			@if($supply_system->status == true)
	    			<img src="{{ asset('images/instructions/ImportProduct.jpg') }}" class="img-import">
	    			@else
	    			<img src="{{ asset('images/instructions/ImportProduct2.jpg') }}" class="img-import">
	    			@endif
	    		</div>
	    	</div>
	    </div>
      </div>
	</div>
  </div>
</div>
<div class="row">
	<div class="col-lg-8 col-md-12 col-sm-12 mb-4">
		<div class="card card-noborder b-radius">
			<div class="card-body">
				<form action="{{ url('/product/create') }}" method="post" name="create_form">
					@csrf
					<div class="form-group row">
			  			<label class="col-12 font-weight-bold col-form-label">Kode Barang <span class="text-danger">*</span></label>
					  	<div class="col-12">
					  		<div class="input-group">
					  			<input type="text" class="form-control number-input" name="kode_barang" placeholder="Masukkan Kode Barang">
					  			<div class="inpu-group-prepend">
					  				<button class="btn btn-inverse-primary btn-sm btn-scan shadow-sm ml-2" type="button" data-toggle="modal" data-target="#scanModal"><i class="mdi mdi-crop-free"></i></button>
					  			</div>
					  		</div>
					  	</div>
						<div class="col-12 error-notice" id="kode_barang_error"></div>
					</div>
					<div class="form-group row">
					  	<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Nama Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
							  		<input type="text" class="form-control" name="nama_barang" placeholder="Masukkan Nama Barang">
							  	</div>
								<div class="col-12 error-notice" id="nama_barang_error"></div>
					  		</div>
					  	</div>
					  	<div class="col-lg-6 col-md-6 col-sm-12">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Jenis Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
							  		<select class="form-control" name="jenis_barang">
							  			<option value="">-- Pilih Jenis Barang --</option>
							  			<option value="Produksi">Produksi</option>
							  			<option value="Konsumsi">Konsumsi</option>
							  		</select>
							  	</div>
								<div class="col-12 error-notice" id="jenis_barang_error"></div>
					  		</div>
					  	</div>
					</div>
					<div class="form-group row">
					  	<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Berat Barang</label>
							  	<div class="col-12">
							  		<div class="input-group">
							  			<input type="text" class="form-control number-input" name="berat_barang" placeholder="Masukkan Berat Barang">
							  			<div class="input-group-append">
							  				<select class="form-control" name="satuan_berat">
							  					<option value="kg">Kilogram</option>
							  					<option value="g">Gram</option>
							  					<option value="ml">Miligram</option>
							  					<option value="oz">Ons</option>
							  					<option value="l">Liter</option>
							  					<option value="ml">Mililiter</option>
							  				</select>
							  			</div>
							  		</div>
							  	</div>
					  		</div>
					  	</div>
					  	<div class="col-lg-6 col-md-6 col-sm-12">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Merek Barang</label>
							  	<div class="col-12">
							  		<input type="text" class="form-control" name="merek" placeholder="Masukkan Merek Barang">
							  	</div>
					  		</div>
					  	</div>
					</div>
					<div class="form-group row">
						@if($supply_system->status == true)
					  	<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Stok Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
							  		<input type="text" class="form-control number-input" name="stok" placeholder="Masukkan Stok Barang">
							  	</div>
								<div class="col-12 error-notice" id="stok_error"></div>
					  		</div>
					  	</div>
					  	@endif
					  	<div class="col-lg-6 col-md-6 col-sm-12">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Harga Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
							  		<div class="input-group">
							  			<div class="input-group-prepend">
							  				<span class="input-group-text">Rp. </span>
							  			</div>
							  			<input type="text" class="form-control number-input" name="harga" placeholder="Masukkan Harga Barang">
							  		</div>
							  	</div>
								<div class="col-12 error-notice" id="harga_error"></div>
					  		</div>
					  	</div>
					</div>
					<div class="row">
						<div class="col-12 mt-2 d-flex justify-content-end">
					  		<button class="btn btn-simpan btn-sm" type="submit"><i class="mdi mdi-content-save"></i> Simpan</button>
					  	</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-12 stretch-card bg-dark-blue">
				<div class="card text-white card-noborder b-radius">
					<div class="card-body">
						<form action="{{ url('/product/import') }}" method="post" enctype="multipart/form-data">
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
			                  <p class="text-white excel-name">Pilih File</p>
			                </div>
			                <button class="btn btn-block mt-3 btn-upload" type="submit" hidden="">Import Data</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12 mt-4">
				<div class="card card-noborder b-radius">
					<div class="card-body">
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
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/js/quagga.min.js') }}"></script>
<script src="{{ asset('js/manage_product/new_product/script.js') }}"></script>
<script type="text/javascript">
  @if ($message = Session::get('create_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif

  @if ($message = Session::get('import_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif
</script>
@endsection
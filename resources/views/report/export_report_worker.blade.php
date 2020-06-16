<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pegawai ({{ date('d M, Y', strtotime($tgl_awal)) . ' - ' . date('d M, Y', strtotime($tgl_akhir))}})</title>
	<style type="text/css">
		html{
			font-family: "Arial", sans-serif;
			margin: 0;
			padding: 0;
		}
		.header{
			background-color: #d3eafc;
			padding: 60px 90px;
		}
		.body{
			padding: 40px 90px;
		}
		/* Text */
		.text-20{
			font-size: 20px;
		}
		.text-18{
			font-size: 18px;
		}
		.text-16{
			font-size: 16px;
		}
		.text-14{
			font-size: 14px;
		}
		.text-12{
			font-size: 12px;
		}
		.text-10{
			font-size: 10px;
		}
		.font-bold{
			font-weight: bold;
		}
		.text-left{
			text-align: left;
		}
		.text-right{
			text-align: right;
		}
		.txt-dark{
			color: #5b5b5b;
		}
		.txt-dark2{
			color: #1d1d1d;
		}
		.txt-blue{
			color: #2a4df1;
		}
		.txt-light{
			color: #acacac;
		}
		.txt-green{
			color: #19d895;
		}
		p{
			margin: 0;
		}

		.d-block{
			display: block;
		}
		.w-100{
			width: 100%;
		}
		.img-td{
			width: 60px;
		}
		.img-td img{
			width: 3rem;
		}
		.mt-2{
			margin-top: 10px;
		}
		.mb-1{
			margin-bottom: 5px;
		}
		.mb-4{
			margin-bottom: 20px;
		}
		.mb-2{
			margin-bottom: 10px;
		}
		.pt-30{
			padding-top: 30px;
		}
		.pt-15{
			padding-top: 15px;
		}
		.pt-5{
			padding-top: 5px;
		}
		.pb-5{
			padding-bottom: 5px;
		}
		table{
			border-collapse: collapse;
		}
		thead tr td{
			border-bottom: 0.5px solid #d9dbe4;
			color: #7e94f6;
			font-size: 12px;
			padding: 10px;
			text-transform: uppercase;
		}
		tbody tr td{
			padding: 7px;
		}
		.border-top-foot{
			border-top: 0.5px solid #d9dbe4;
		}
		.mr-20{
			margin-right: 20px;
		}
		ul{
			padding: 0;
		}
		ul li{
			list-style-type: none;
		}
		.w-300p{
			width: 300px;
		}
		.judul-laporan{
			color: #ffaf00;
    		background-color: rgba(255, 175, 0, 0.2);
			border-radius: 5px;
			height: 20px;
			padding: 5px;
			text-align: center;
		}
		.page_break {
			page-break-before: always;
		}
	</style>
</head>
<body>
	@if($pasok != '' && $jml_act_pasok != 0)
	<div class="header">
		<table class="w-100">
			<tr>
				<td class="img-td text-left"><img src="{{ asset('icons/logo-mini2.png') }}"></td>
				<td class="text-left">
					<p class="text-12 txt-dark d-block mb-1">{{ $market->nama_toko }}</p>
					<p class="text-10 txt-dark d-block">{{ $market->alamat }}</p>
					<p class="text-10 txt-dark d-block">{{ $market->no_telp }}</p>
				</td>
				<td class="text-right">
					<p class="text-20 txt-blue font-bold">LAPORAN PEGAWAI</p>
				</td>
			</tr>
			<tr>
				<td class="text-left txt-blue text-12 font-bold pt-30" colspan="2">Periode Laporan</td>
				<td class="text-right text-12 txt-dark pt-30">{{ \Carbon\Carbon::now()->isoFormat('DD MMM, Y') }}</td>
			</tr>
			<tr>
				<td class="text-left text-12 txt-dark2" colspan="2">{{ date('d M, Y', strtotime($tgl_awal)) . ' - ' . date('d M, Y', strtotime($tgl_akhir))}}</td>
				@php
				$nama_users = explode(' ',auth()->user()->nama);
				$nama_user = $nama_users[0];
				@endphp
				<td class="text-right text-12 txt-blue">Oleh {{ $nama_user }}</td>
			</tr>
			<tr>
				@php
				$pegawai = \App\User::find($id);
				@endphp
				<td colspan="2" class="pt-30">
					<span class="d-block text-10">NAMA</span>
					<span class="txt-blue d-block text-12 mb-1">{{ $pegawai->nama }}</span>
					<span class="d-block text-10">EMAIL</span>
					<span class="txt-blue d-block text-12">{{ $pegawai->email }}</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="body">
		<div class="judul-laporan text-14 d-block">
			RIWAYAT PASOK
		</div>
		<ul>
			@php
			$pengeluaran = 0;
			$jml_aktv_pengeluaran = 0;
			@endphp
			@foreach($pasok as $date)
			<li class="text-10 txt-light">{{ date('d M, Y', strtotime($date)) }}</li>
			@php
			$supplies = \App\Supply::whereDate('supplies.created_at', $date)
			->where('id_pemasok', $id)
			->select('supplies.*')
			->latest()
			->get();
			@endphp
			<table class="w-100 mb-4">
				<thead>
					<tr>
						<td>Waktu</td>
						<td>Barang</td>
						<td>Jumlah</td>
						<td>Harga</td>
						<td>Total</td>
					</tr>
				</thead>
				<tbody>
					@foreach($supplies as $supply)
					<tr>
						<td class="text-left text-12 txt-dark">{{ date('H:i', strtotime($supply->created_at)) }}</td>
						<td>
							<span class="text-left d-block text-12 txt-dark2">{{ $supply->nama_barang }}</span>
							<span class="text-left d-block text-10 txt-light">{{ $supply->kode_barang }}</span>
						</td>
						<td class="text-left text-12 txt-dark2">{{ $supply->jumlah }}</td>
						<td class="text-left text-12 txt-dark">Rp. {{ number_format($supply->harga_beli,2,',','.') }}</td>
						@php
						$total = $supply->jumlah * $supply->harga_beli;
						$pengeluaran += $total;
						$jml_aktv_pengeluaran += 1;
						@endphp
						<td class="text-left text-12 txt-green">Rp. {{ number_format($total,2,',','.') }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endforeach
		</ul>
		<table class="w-100">
			<tfoot>
				<tr>
					<td class="border-top-foot"></td>
				</tr>
				<tr>
					<td class="text-14 pt-15 text-right">
						<span class="mr-20">JUMLAH AKTIVITAS</span>
						<span class="txt-blue font-bold">{{ $jml_aktv_pengeluaran }}</span>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	@endif
	@if($transaksi != '' && $pasok != '' && $jml_act_trans != 0 && $jml_act_pasok != 0)
	<div class="page_break"></div>
	@endif
	@if($transaksi != '' && $jml_act_trans != 0)
	<div class="header">
		<table class="w-100">
			<tr>
				<td class="img-td text-left"><img src="{{ asset('icons/logo-mini2.png') }}"></td>
				<td class="text-left">
					<p class="text-12 txt-dark d-block mb-1">{{ $market->nama_toko }}</p>
					<p class="text-10 txt-dark d-block">{{ $market->alamat }}</p>
					<p class="text-10 txt-dark d-block">{{ $market->no_telp }}</p>
				</td>
				<td class="text-right">
					<p class="text-20 txt-blue font-bold">LAPORAN PEGAWAI</p>
				</td>
			</tr>
			<tr>
				<td class="text-left txt-blue text-12 font-bold pt-30" colspan="2">Periode Laporan</td>
				<td class="text-right text-12 txt-dark pt-30">{{ \Carbon\Carbon::now()->isoFormat('DD MMM, Y') }}</td>
			</tr>
			<tr>
				<td class="text-left text-12 txt-dark2" colspan="2">{{ date('d M, Y', strtotime($tgl_awal)) . ' - ' . date('d M, Y', strtotime($tgl_akhir))}}</td>
				@php
				$nama_users = explode(' ',auth()->user()->nama);
				$nama_user = $nama_users[0];
				@endphp
				<td class="text-right text-12 txt-blue">Oleh {{ $nama_user }}</td>
			</tr>
			<tr>
				@php
				$pegawai = \App\User::find($id);
				@endphp
				<td colspan="2" class="pt-30">
					<span class="d-block text-10">NAMA</span>
					<span class="txt-blue d-block text-12 mb-1">{{ $pegawai->nama }}</span>
					<span class="d-block text-10">EMAIL</span>
					<span class="txt-blue d-block text-12">{{ $pegawai->email }}</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="body">
		<div class="judul-laporan text-14 d-block">
			RIWAYAT TRANSAKSI
		</div>
		<ul>
			@php
			$pemasukan = 0;
			$jml_aktv_pemasukan = 0;
			@endphp
			@foreach($transaksi as $date)
			<li class="text-10 txt-light mt-2">{{ date('d M, Y', strtotime($date)) }}</li>
			@php
			$transactions = \App\Transaction::whereDate('transactions.created_at', $date)
			->where('id_kasir', $id)
			->select('transactions.*')
			->latest()
			->get();
			@endphp
			<table class="w-100 mb-4">
				<thead>
					<tr>
						<td colspan="5"></td>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
					<tr>
						<td class="text-left text-12 txt-dark">{{ date('H:i', strtotime($transaction->created_at)) }}</td>
						<td>
							<span class="text-12 txt-dark2 d-block">{{ $transaction->kode_transaksi }}</span>
							@php
							$jml_barang = \App\Transaction::where('kode_transaksi', $transaction->kode_transaksi)
							->count();
							@endphp
							<span class="text-10 txt-light d-block">Jumlah Barang : {{ $jml_barang }}</span>
						</td>
						<td>
							<span class="text-10 txt-light d-block">Total</span>
							<span class="txt-green text-12 d-block">Rp. {{ number_format($transaction->total,2,',','.') }}</span>
						</td>
						@php
						$pemasukan += $transaction->total;
						$jml_aktv_pemasukan += 1;
						@endphp
						<td>
							<span class="text-10 txt-light d-block">Bayar</span>
							<span class="txt-dark2 text-12 d-block">Rp. {{ number_format($transaction->bayar,2,',','.') }}</span>
						</td>
						<td>
							<span class="text-10 txt-light d-block">Kembali</span>
							<span class="txt-dark text-12 d-block">Rp. {{ number_format($transaction->kembali,2,',','.') }}</span>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endforeach
		</ul>
		<table class="w-100">
			<tfoot>
				<tr>
					<td class="border-top-foot"></td>
				</tr>
				<tr>
					<td class="text-14 pt-15 text-right">
						<span class="mr-20">JUMLAH AKTIVITAS</span>
						<span class="txt-blue font-bold">{{ $jml_aktv_pemasukan }}</span>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	@endif
</body>
</html>
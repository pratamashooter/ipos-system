<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pengeluaran ({{ date('d M, Y', strtotime($tgl_awal)) . ' - ' . date('d M, Y', strtotime($tgl_akhir))}})</title>
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
		.text-center{
			text-align: center;
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
		.mb-1{
			margin-bottom: 5px;
		}
		.mb-4{
			margin-bottom: 20px;
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
		ul{
			padding: 0;
		}
		ul li{
			list-style-type: none;
		}
		.w-300p{
			width: 300px;
		}
		.mr-20{
			margin-right: 20px;
		}
	</style>
</head>
<body>
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
					<p class="text-20 txt-blue font-bold">LAPORAN PENGELUARAN</p>
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
		</table>
	</div>
	<div class="body">
		<ul>
			@php
			$pengeluaran = 0;
			@endphp
			@foreach($dates as $date)
			<li class="text-10 txt-light">{{ date('d M, Y', strtotime($date)) }}</li>
			@php
			$supplies = \App\Supply::whereDate('supplies.created_at', $date)
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
						<td>Pemasok</td>
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
						@endphp
						<td class="text-left text-12 txt-green">Rp. {{ number_format($total,2,',','.') }}</td>
						<td class="text-left text-12">{{ $supply->pemasok }}</td>
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
						<span class="mr-20">PENGELUARAN</span>
						<span class="txt-blue font-bold">Rp. {{ number_format($pengeluaran,2,',','.') }}</span>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>
</html>
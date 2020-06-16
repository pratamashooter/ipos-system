<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Carbon\Carbon;
use App\User;
use App\Acces;
use App\Market;
use App\Supply;
use App\Transaction;
use Illuminate\Http\Request;

class ReportManageController extends Controller
{
    // Show View Report Transaction
    public function reportTransaction()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
        	$transactions = Transaction::all();
            $array = array();
            foreach ($transactions as $no => $transaction) {
                array_push($array, $transactions[$no]->created_at->toDateString());
            }
            $dates = array_unique($array);
            rsort($dates);

            $arr_ammount = count($dates);
            $incomes_data = array();
            if($arr_ammount > 7){
            	for ($i = 0; $i < 7; $i++) { 
            		array_push($incomes_data, $dates[$i]);	
            	}
            }elseif($arr_ammount > 0){
            	for ($i = 0; $i < $arr_ammount; $i++) { 
            		array_push($incomes_data, $dates[$i]);
            	}
            }
            $incomes = array_reverse($incomes_data);

        	return view('report.report_transaction', compact('dates', 'incomes'));
        }else{
            return back();
        }
    }

    // Show View Report Worker
    public function reportWorker()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
            $users = User::all();

            return view('report.report_worker', compact('users'));
        }else{
            return back();
        }
    }

    // Filter Report Transaction
    public function filterTransaction(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
        	$start_date = $req->tgl_awal;
        	$end_date = $req->tgl_akhir;
        	$start_date2 = $start_date[6].$start_date[7].$start_date[8].$start_date[9].'-'.$start_date[3].$start_date[4].'-'.$start_date[0].$start_date[1].' 00:00:00';
        	$end_date2 = $end_date[6].$end_date[7].$end_date[8].$end_date[9].'-'.$end_date[3].$end_date[4].'-'.$end_date[0].$end_date[1].' 23:59:59';
        	$supplies = Transaction::select()
        	->whereBetween('created_at', array($start_date2, $end_date2))
        	->get();
            $array = array();
            foreach ($supplies as $no => $supply) {
                array_push($array, $supplies[$no]->created_at->toDateString());
            }
            $dates = array_unique($array);
            rsort($dates);

        	return view('report.report_transaction_filter', compact('dates'));
        }else{
            return back();
        }
    }

    // Filter Report Worker
    public function filterWorker($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
            $users = User::orderBy($id, 'asc')
            ->get();
            
            return view('report.filter_table.filter_table_worker', compact('users'));
        }else{
            return back();
        }
    }

    // Filter Chart Transaction
    public function chartTransaction($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
        	$supplies = Transaction::all();
            $array = array();
            foreach ($supplies as $no => $supply) {
                array_push($array, $supplies[$no]->created_at->toDateString());
            }
            $dates = array_unique($array);
            rsort($dates);
            $arr_ammount = count($dates);
            $incomes_data = array();

        	if($id == 'minggu'){
        		if($arr_ammount > 7){
    	        	for ($i = 0; $i < 7; $i++) { 
    	        		array_push($incomes_data, $dates[$i]);	
    	        	}
    	        }elseif($arr_ammount > 0){
    	        	for ($i = 0; $i < $arr_ammount; $i++) { 
    	        		array_push($incomes_data, $dates[$i]);
    	        	}
    	        }
    	        $incomes = array_reverse($incomes_data);
    	        $total = array();
    	        foreach ($incomes as $no => $income) {
    	        	array_push($total, Transaction::whereDate('created_at', $income)->sum('total'));
    	        }

    	        return response()->json([
    	        	'incomes' => $incomes, 
    	        	'total' => $total
    	        ]);
        	}elseif($id == 'bulan'){
        		if($arr_ammount > 30){
    	        	for ($i = 0; $i < 30; $i++) { 
    	        		array_push($incomes_data, $dates[$i]);	
    	        	}
    	        }elseif($arr_ammount > 0){
    	        	for ($i = 0; $i < $arr_ammount; $i++) { 
    	        		array_push($incomes_data, $dates[$i]);
    	        	}
    	        }
    	        $incomes = array_reverse($incomes_data);
    	        $total = array();
    	        foreach ($incomes as $no => $income) {
    	        	array_push($total, Transaction::whereDate('created_at', $income)->sum('total'));
    	        }

    	        return response()->json([
    	        	'incomes' => $incomes, 
    	        	'total' => $total
    	        ]);
        	}elseif($id == 'tahun'){
        		if($arr_ammount > 365){
    	        	for ($i = 0; $i < 365; $i++) { 
    	        		array_push($incomes_data, $dates[$i]);	
    	        	}
    	        }elseif($arr_ammount > 0){
    	        	for ($i = 0; $i < $arr_ammount; $i++) { 
    	        		array_push($incomes_data, $dates[$i]);
    	        	}
    	        }
    	        $incomes = array_reverse($incomes_data);
    	        $total = array();
    	        foreach ($incomes as $no => $income) {
    	        	array_push($total, Transaction::whereDate('created_at', $income)->sum('total'));
    	        }

    	        return response()->json([
    	        	'incomes' => $incomes, 
    	        	'total' => $total
    	        ]);
        	}
        }else{
            return back();
        }
    }

    // Detail Report Worker
    public function detailWorker($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
            $worker = User::find($id);
            $supplies = Supply::select('supplies.*')
            ->where('id_pemasok', $id)
            ->get();
            $array_1 = array();
            foreach ($supplies as $no => $supply) {
                array_push($array_1, $supplies[$no]->created_at->toDateString());
            }
            $dates_1 = array_unique($array_1);
            rsort($dates_1);

            $transactions = Transaction::select('transactions.*')
            ->where('id_kasir', $id)
            ->get();
            $array_2 = array();
            foreach ($transactions as $no => $transaction) {
                array_push($array_2, $transactions[$no]->created_at->toDateString());
            }
            $dates_2 = array_unique($array_2);
            rsort($dates_2);

            return view('report.detail_report_worker', compact('worker', 'dates_1', 'dates_2'));
        }else{
            return back();
        }
    }

    // Export Transaction Report
    public function exportTransaction(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
            $jenis_laporan = $req->jns_laporan;
            $current_time = Carbon::now()->isoFormat('Y-MM-DD') . ' 23:59:59';
            if($jenis_laporan == 'period'){
                if($req->period == 'minggu'){
                    $last_time = Carbon::now()->subWeeks($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $transactions = Transaction::select('transactions.*')
                    ->whereBetween('created_at', array($last_time, $current_time))
                    ->get();
                    $array = array();
                    foreach ($transactions as $no => $transaction) {
                        array_push($array, $transactions[$no]->created_at->toDateString());
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }elseif($req->period == 'bulan'){
                    $last_time = Carbon::now()->subMonths($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $transactions = Transaction::select('transactions.*')
                    ->whereBetween('created_at', array($last_time, $current_time))
                    ->get();
                    $array = array();
                    foreach ($transactions as $no => $transaction) {
                        array_push($array, $transactions[$no]->created_at->toDateString());
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }elseif($req->period == 'tahun'){
                    $last_time = Carbon::now()->subYears($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $transactions = Transaction::select('transactions.*')
                    ->whereBetween('created_at', array($last_time, $current_time))
                    ->get();
                    $array = array();
                    foreach ($transactions as $no => $transaction) {
                        array_push($array, $transactions[$no]->created_at->toDateString());
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }
            }else{
                $start_date = $req->tgl_awal_export;
                $end_date = $req->tgl_akhir_export;
                $start_date2 = $start_date[6].$start_date[7].$start_date[8].$start_date[9].'-'.$start_date[3].$start_date[4].'-'.$start_date[0].$start_date[1].' 00:00:00';
                $end_date2 = $end_date[6].$end_date[7].$end_date[8].$end_date[9].'-'.$end_date[3].$end_date[4].'-'.$end_date[0].$end_date[1].' 23:59:59';
                $transactions = Transaction::select('transactions.*')
                ->whereBetween('created_at', array($start_date2, $end_date2))
                ->get();
                $array = array();
                foreach ($transactions as $no => $transaction) {
                    array_push($array, $transactions[$no]->created_at->toDateString());
                }
                $dates = array_unique($array);
                rsort($dates);
                $tgl_awal = $start_date2;
                $tgl_akhir = $end_date2;
            }
            $market = Market::first();

            $pdf = PDF::loadview('report.export_report_transaction', compact('dates', 'tgl_awal', 'tgl_akhir', 'market'));
            return $pdf->stream();
        }else{
            return back();
        }
    }

    // Export Worker Report
    public function exportWorker(Request $req, $id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_laporan == 1){
            $jml_laporan = count($req->laporan);

            $jenis_laporan = $req->jns_laporan;
            $current_time = Carbon::now()->isoFormat('Y-MM-DD') . ' 23:59:59';
            if($jenis_laporan == 'period'){
                if($req->period == 'minggu'){
                    $last_time = Carbon::now()->subWeeks($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    if(count($req->laporan) == 2){
                        $transactions = Transaction::select('transactions.*')
                        ->where('id_kasir', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($transactions as $no => $transaction) {
                            array_push($array, $transactions[$no]->created_at->toDateString());
                        }
                        $transaksi = array_unique($array);
                        rsort($transaksi);
                        $supplies = Supply::select('supplies.*')
                        ->where('id_pemasok', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($supplies as $no => $supply) {
                            array_push($array, $supplies[$no]->created_at->toDateString());
                        }
                        $pasok = array_unique($array);
                        rsort($pasok);
                    }elseif($req->laporan[0] == 'pasok'){
                        $transaksi = '';
                        $supplies = Supply::select('supplies.*')
                        ->where('id_pemasok', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($supplies as $no => $supply) {
                            array_push($array, $supplies[$no]->created_at->toDateString());
                        }
                        $pasok = array_unique($array);
                        rsort($pasok);
                    }elseif($req->laporan[0] == 'transaksi'){
                        $transactions = Transaction::select('transactions.*')
                        ->where('id_kasir', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($transactions as $no => $transaction) {
                            array_push($array, $transactions[$no]->created_at->toDateString());
                        }
                        $transaksi = array_unique($array);
                        rsort($transaksi);
                        $pasok = '';
                    }
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }elseif($req->period == 'bulan'){
                    $last_time = Carbon::now()->subMonths($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    if(count($req->laporan) == 2){
                        $transactions = Transaction::select('transactions.*')
                        ->where('id_kasir', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($transactions as $no => $transaction) {
                            array_push($array, $transactions[$no]->created_at->toDateString());
                        }
                        $transaksi = array_unique($array);
                        rsort($transaksi);
                        $supplies = Supply::select('supplies.*')
                        ->where('id_pemasok', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($supplies as $no => $supply) {
                            array_push($array, $supplies[$no]->created_at->toDateString());
                        }
                        $pasok = array_unique($array);
                        rsort($pasok);
                    }elseif($req->laporan[0] == 'pasok'){
                        $transaksi = '';
                        $supplies = Supply::select('supplies.*')
                        ->where('id_pemasok', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($supplies as $no => $supply) {
                            array_push($array, $supplies[$no]->created_at->toDateString());
                        }
                        $pasok = array_unique($array);
                        rsort($pasok);
                    }elseif($req->laporan[0] == 'transaksi'){
                        $transactions = Transaction::select('transactions.*')
                        ->where('id_kasir', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($transactions as $no => $transaction) {
                            array_push($array, $transactions[$no]->created_at->toDateString());
                        }
                        $transaksi = array_unique($array);
                        rsort($transaksi);
                        $pasok = '';
                    }
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }elseif($req->period == 'tahun'){
                    $last_time = Carbon::now()->subYears($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    if(count($req->laporan) == 2){
                        $transactions = Transaction::select('transactions.*')
                        ->where('id_kasir', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($transactions as $no => $transaction) {
                            array_push($array, $transactions[$no]->created_at->toDateString());
                        }
                        $transaksi = array_unique($array);
                        rsort($transaksi);
                        $supplies = Supply::select('supplies.*')
                        ->where('id_pemasok', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($supplies as $no => $supply) {
                            array_push($array, $supplies[$no]->created_at->toDateString());
                        }
                        $pasok = array_unique($array);
                        rsort($pasok);
                    }elseif($req->laporan[0] == 'pasok'){
                        $transaksi = '';
                        $supplies = Supply::select('supplies.*')
                        ->where('id_pemasok', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($supplies as $no => $supply) {
                            array_push($array, $supplies[$no]->created_at->toDateString());
                        }
                        $pasok = array_unique($array);
                        rsort($pasok);
                    }elseif($req->laporan[0] == 'transaksi'){
                        $transactions = Transaction::select('transactions.*')
                        ->where('id_kasir', $id)
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                        $array = array();
                        foreach ($transactions as $no => $transaction) {
                            array_push($array, $transactions[$no]->created_at->toDateString());
                        }
                        $transaksi = array_unique($array);
                        rsort($transaksi);
                        $pasok = '';
                    }
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }
            }else{
                $start_date = $req->tgl_awal_export;
                $end_date = $req->tgl_akhir_export;
                $start_date2 = $start_date[6].$start_date[7].$start_date[8].$start_date[9].'-'.$start_date[3].$start_date[4].'-'.$start_date[0].$start_date[1].' 00:00:00';
                $end_date2 = $end_date[6].$end_date[7].$end_date[8].$end_date[9].'-'.$end_date[3].$end_date[4].'-'.$end_date[0].$end_date[1].' 23:59:59';
                if(count($req->laporan) == 2){
                    $transactions = Transaction::select('transactions.*')
                    ->where('id_kasir', $id)
                    ->whereBetween('created_at', array($start_date2, $end_date2))
                    ->get();
                    $array = array();
                    foreach ($transactions as $no => $transaction) {
                        array_push($array, $transactions[$no]->created_at->toDateString());
                    }
                    $transaksi = array_unique($array);
                    rsort($transaksi);
                    $supplies = Supply::select('supplies.*')
                    ->where('id_pemasok', $id)
                    ->whereBetween('created_at', array($start_date2, $end_date2))
                    ->get();
                    $array = array();
                    foreach ($supplies as $no => $supply) {
                        array_push($array, $supplies[$no]->created_at->toDateString());
                    }
                    $pasok = array_unique($array);
                    rsort($pasok);
                }elseif($req->laporan[0] == 'pasok'){
                    $transaksi = '';
                    $supplies = Supply::select('supplies.*')
                    ->where('id_pemasok', $id)
                    ->whereBetween('created_at', array($start_date2, $end_date2))
                    ->get();
                    $array = array();
                    foreach ($supplies as $no => $supply) {
                        array_push($array, $supplies[$no]->created_at->toDateString());
                    }
                    $pasok = array_unique($array);
                    rsort($pasok);
                }elseif($req->laporan[0] == 'transaksi'){
                    $transactions = Transaction::select('transactions.*')
                    ->where('id_kasir', $id)
                    ->whereBetween('created_at', array($start_date2, $end_date2))
                    ->get();
                    $array = array();
                    foreach ($transactions as $no => $transaction) {
                        array_push($array, $transactions[$no]->created_at->toDateString());
                    }
                    $transaksi = array_unique($array);
                    rsort($transaksi);
                    $pasok = '';
                }
                $tgl_awal = $start_date2;
                $tgl_akhir = $end_date2;
            }
            $jml_act_pasok = Supply::where('id_pemasok', $id)
            ->count();
            $jml_act_trans = Transaction::where('id_kasir', $id)
            ->count();
            $market = Market::first();

            $pdf = PDF::loadview('report.export_report_worker', compact('transaksi', 'pasok', 'tgl_awal', 'tgl_akhir', 'id', 'jml_act_pasok', 'jml_act_trans', 'market'));
            return $pdf->stream();
        }else{
            return back();
        }
    }
}
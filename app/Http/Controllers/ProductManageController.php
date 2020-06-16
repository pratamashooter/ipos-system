<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Acces;
use App\Supply;
use App\Product;
use App\Transaction;
use App\Supply_system;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProductManageController extends Controller
{
    // Show View Product
    public function viewProduct()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
        	$products = Product::all()
            ->sortBy('kode_barang');
            $supply_system = Supply_system::first();

        	return view('manage_product.product', compact('products', 'supply_system'));
        }else{
            return back();
        }
    }

    // Show View New Product
    public function viewNewProduct()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
            $supply_system = Supply_system::first();

        	return view('manage_product.new_product', compact('supply_system'));
        }else{
            return back();
        }
    }

    // Filter Product Table
    public function filterTable($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
            $supply_system = Supply_system::first();
            $products = Product::orderBy($id, 'asc')
            ->get();

            return view('manage_product.filter_table.table_view', compact('products', 'supply_system'));
        }else{
            return back();
        }
    }

    // Create New Product
    public function createProduct(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
        	$check_product = Product::where('kode_barang', $req->kode_barang)
        	->count();
            $supply_system = Supply_system::first();

        	if($check_product == 0)
        	{
        		$product = new Product;
    	    	$product->kode_barang = $req->kode_barang;
    	    	$product->jenis_barang = $req->jenis_barang;
    	    	$product->nama_barang = $req->nama_barang;
    	    	if($req->berat_barang != '')
    	    	{
    	    		$product->berat_barang = $req->berat_barang . ' ' . $req->satuan_berat;
    	    	}
    	    	if($req->merek != '')
    	    	{
    	    		$product->merek = $req->merek;
    	    	}
                if($supply_system->status == true){
                    $product->stok = $req->stok;
                }else{
                    $product->stok = 1;
                }
    	    	$product->harga = $req->harga;
    	    	$product->save();

    	    	Session::flash('create_success', 'Barang baru berhasil ditambahkan');

    		    return redirect('/product');
        	}else{
        		Session::flash('create_failed', 'Kode barang telah digunakan');

    		    return back();
        	}
    	}else{
            return back();
        }
    }

    // Import New Product
    public function importProduct(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
        	try{
        		$file = $req->file('excel_file');
    			$nama_file = rand().$file->getClientOriginalName();
    			$file->move('excel_file', $nama_file);
    			Excel::import(new ProductImport, public_path('/excel_file/'.$nama_file));

    			Session::flash('import_success', 'Data barang berhasil diimport');
        	}catch(\Exception $ex){
        		Session::flash('import_failed', 'Cek kembali terdapat data kosong atau kode barang yang telah tersedia');

        		return back();
        	}

        	return redirect('/product');
        }else{
            return back();
        }
    }

    // Edit Product
    public function editProduct($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
            $product = Product::find($id);

            return response()->json(['product' => $product]);
        }else{
            return back();
        }
    }

    // Update Product
    public function updateProduct(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
            $check_product = Product::where('kode_barang', $req->kode_barang)
            ->count();
            $product_data = Product::find($req->id);
            if($check_product == 0 || $product_data->kode_barang == $req->kode_barang)
            {
                $product = Product::find($req->id);
                $kode_barang = $product->kode_barang;
                $product->kode_barang = $req->kode_barang;
                $product->jenis_barang = $req->jenis_barang;
                $product->nama_barang = $req->nama_barang;
                $product->berat_barang = $req->berat_barang . ' ' . $req->satuan_berat;
                $product->merek = $req->merek;
                $product->stok = $req->stok;
                $product->harga = $req->harga;
                if($req->stok <= 0)
                {
                    $product->keterangan = "Habis";
                }else{
                    $product->keterangan = "Tersedia";
                }
                $product->save();

                Supply::where('kode_barang', $kode_barang)
                ->update(['kode_barang' => $req->kode_barang]);
                Transaction::where('kode_barang', $kode_barang)
                ->update(['kode_barang' => $req->kode_barang]);

                Session::flash('update_success', 'Data barang berhasil diubah');

                return redirect('/product');
            }else{
                Session::flash('update_failed', 'Kode barang telah digunakan');

                return back();
            }
        }else{
            return back();
        }
    }

    // Delete Product
    public function deleteProduct($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)
        ->first();
        if($check_access->kelola_barang == 1){
            Product::destroy($id);

            Session::flash('delete_success', 'Barang berhasil dihapus');

            return back();
        }else{
            return back();
        }
    }
}

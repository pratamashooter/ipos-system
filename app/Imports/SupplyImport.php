<?php

namespace App\Imports;

use Auth;
use App\Supply;
use App\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class SupplyImport implements ToModel, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable;
    
    public function model(array $row)
    {
        $product_status = Product::where('kode_barang', $row[0])
        ->first();
        if($product_status->stok == 0){
            $product_status->keterangan = 'Tersedia';
            $product_status->save();
        }
        $product = Product::where('kode_barang', $row[0])
        ->select('products.*')
        ->first();

        return new Supply([
            'kode_barang'     => $row[0],
            'nama_barang'     => $product_status->nama_barang,
            'jumlah'    => $row[1],
            'harga_beli'    => $row[2],
            'id_pemasok'    => Auth::id(),
            'pemasok'    => Auth::user()->nama,
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => function($attribute, $value, $onFailure) {
                if (Product::where('kode_barang', '=', $value)->count() == 0) {
                    $onFailure('tidak tersedia');
                }elseif ($value == null || $value == '') {
                    $onFailure('kosong');
                }elseif ($value == 0) {
                    $onFailure('nol');
                }
            },
            '1' => 'required|numeric',
            '2' => 'required|numeric',
        ];
    }
}

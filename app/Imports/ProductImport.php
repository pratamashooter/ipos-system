<?php

namespace App\Imports;

use App\Product;
use App\Supply_system;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToModel, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (Supply_system::first()->status == true) {
            return new Product([
                'kode_barang'     => $row[0],
                'jenis_barang'    => $row[1],
                'nama_barang'    => $row[2],
                'berat_barang'    => $row[3],
                'merek'    => $row[4],
                'stok'    => $row[5],
                'harga'    => $row[6],
            ]);
        }else{
            return new Product([
                'kode_barang'     => $row[0],
                'jenis_barang'    => $row[1],
                'nama_barang'    => $row[2],
                'berat_barang'    => $row[3],
                'merek'    => $row[4],
                'harga'    => $row[5],
            ]);
        }
    }

    public function rules(): array
    {
        if (Supply_system::first()->status == true) {   
            return [
                '0' => function($attribute, $value, $onFailure) {
                    if (Product::where('kode_barang', '=', $value)->count() > 0) {
                        $onFailure('tersedia');
                    }elseif ($value == null || $value == '') {
                        $onFailure('kosong');
                    }elseif ($value == 0) {
                        $onFailure('nol');
                    }
                },
                '1' => 'required|string',
                '2' => 'required|string',
                '6' => 'required|numeric',
            ];
        }else{
            return [
                '0' => function($attribute, $value, $onFailure) {
                    if (Product::where('kode_barang', '=', $value)->count() > 0) {
                        $onFailure('tersedia');
                    }elseif ($value == null || $value == '') {
                        $onFailure('kosong');
                    }elseif ($value == 0) {
                        $onFailure('nol');
                    }
                },
                '1' => 'required|string',
                '2' => 'required|string',
                '5' => 'required|numeric',
            ];
        }
    }
}

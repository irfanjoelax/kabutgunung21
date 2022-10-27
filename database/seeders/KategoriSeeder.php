<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'id'   => Str::uuid(),
            'name' => 'Case Handphone',
        ])->each(
            function ($kategori) {
                Produk::create([
                    'id'          => Str::uuid(),
                    'sku'         => '001-BRG-TOKOPEDIA',
                    'nama'        => 'Case One Piece Movie Red',
                    'kategori_id' => $kategori->id,
                    'harga_beli'  => 12500,
                    'stok'        => 45
                ]);
            }
        );;
    }
}

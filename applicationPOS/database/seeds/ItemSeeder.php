<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Item::create([
            'nama_barang' => 'Roti Coklat',
            'harga' => 3000,
            'stok' => 5,
            'tipe_barang' => 'snack'
        ]);
        Item::create([
            'nama_barang' => 'Indomie',
            'harga' => 5000,
            'stok' => 10,
            'tipe_barang' => 'makanan'
        ]);
        Item::create([
            'nama_barang' => 'Nutrisari',
            'harga' => 3000,
            'stok' => 20,
            'tipe_barang' => 'minuman'
        ]);
        Item::create([
            'nama_barang' => 'Oreo',
            'harga' => 2000,
            'stok' => 4,
            'tipe_barang' => 'snack'
        ]);
    }
}

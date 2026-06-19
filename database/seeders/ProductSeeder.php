<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriMultimedia = Category::create(['nama' => 'Multimedia']);
        $kategoriUtilitas   = Category::create(['nama' => 'Utilitas']);
        $kategoriKomunikasi = Category::create(['nama' => 'Komunikasi']);

        $aula = Product::create([
            'category_id' => $kategoriMultimedia->id,
            'nama'        => 'Paket Aula Lt.1',
            'slug'        => 'aula',
            'status'      => 'tersedia',
        ]);
        ProductItem::insert([
            ['product_id' => $aula->id, 'nama_item' => 'Videotron 5x2.5m', 'qty' => 1],
            ['product_id' => $aula->id, 'nama_item' => 'Speaker FOH Baretone 15RC', 'qty' => 2],
            ['product_id' => $aula->id, 'nama_item' => 'Mixer Yamaha MGP-24', 'qty' => 1],
            ['product_id' => $aula->id, 'nama_item' => 'TV LG 75 Time Keeper', 'qty' => 1],
        ]);

        $streaming = Product::create([
            'category_id' => $kategoriMultimedia->id,
            'nama'        => 'Paket Streaming',
            'slug'        => 'streaming',
            'status'      => 'tersedia',
        ]);
        ProductItem::insert([
            ['product_id' => $streaming->id, 'nama_item' => 'Camcorder Sony', 'qty' => 1],
            ['product_id' => $streaming->id, 'nama_item' => 'Atem Mini Pro', 'qty' => 1],
            ['product_id' => $streaming->id, 'nama_item' => 'Capture Card HDMI', 'qty' => 1],
            ['product_id' => $streaming->id, 'nama_item' => 'Tripod', 'qty' => 1],
        ]);

        $listrik = Product::create([
            'category_id' => $kategoriUtilitas->id,
            'nama'        => 'Paket Listrik',
            'slug'        => 'listrik',
            'status'      => 'tersedia',
        ]);
        ProductItem::insert([
            ['product_id' => $listrik->id, 'nama_item' => 'Kabel Roll 5 Meter', 'qty' => 3],
        ]);

        $komunikasi = Product::create([
            'category_id' => $kategoriKomunikasi->id,
            'nama'        => 'Paket Komunikasi',
            'slug'        => 'komunikasi',
            'status'      => 'tersedia',
        ]);
        ProductItem::insert([
            ['product_id' => $komunikasi->id, 'nama_item' => 'Handy Talkie (HT) + Charger', 'qty' => 4],
        ]);
    }
}

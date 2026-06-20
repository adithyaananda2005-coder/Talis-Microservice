<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nama_paket' => 'Paket Aula Lt.1',
                'key_paket'  => 'aula',
                'status'     => 'tersedia',
                'items' => [
                    ['nama_barang' => 'Videotron 5x2.5m',         'qty' => 1],
                    ['nama_barang' => 'Speaker FOH Baretone 15RC', 'qty' => 2],
                    ['nama_barang' => 'Mixer Yamaha MGP-24',       'qty' => 1],
                    ['nama_barang' => 'TV LG 75" Time Keeper',     'qty' => 1],
                ],
            ],
            [
                'nama_paket' => 'Paket Streaming',
                'key_paket'  => 'streaming',
                'status'     => 'tersedia',
                'items' => [
                    ['nama_barang' => 'Camcorder Sony',   'qty' => 1],
                    ['nama_barang' => 'Atem Mini Pro',     'qty' => 1],
                    ['nama_barang' => 'Capture Card HDMI', 'qty' => 1],
                    ['nama_barang' => 'Tripod',            'qty' => 2],
                ],
            ],
            [
                'nama_paket' => 'Paket Listrik',
                'key_paket'  => 'listrik',
                'status'     => 'tersedia',
                'items' => [
                    ['nama_barang' => 'Kabel Roll 5 Meter', 'qty' => 3],
                ],
            ],
            [
                'nama_paket' => 'Paket Komunikasi',
                'key_paket'  => 'komunikasi',
                'status'     => 'tersedia',
                'items' => [
                    ['nama_barang' => 'Handy Talkie (HT) + Charger', 'qty' => 4],
                ],
            ],
        ];

        foreach ($pakets as $paket) {
            $asset = DB::table('assets')->insertGetId([
                'nama_paket' => $paket['nama_paket'],
                'key_paket'  => $paket['key_paket'],
                'status'     => $paket['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($paket['items'] as $item) {
                DB::table('asset_items')->insert([
                    'asset_id'    => $asset,
                    'nama_barang' => $item['nama_barang'],
                    'qty'         => $item['qty'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }
    }
}

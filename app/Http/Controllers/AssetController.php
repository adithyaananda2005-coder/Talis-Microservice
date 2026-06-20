<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller

{
    public function getDetail($nama_paket)
    {
        $packages = [
            'aula' => [
                'nama'   => 'Paket Aula Lt.1',
                'status' => 'tersedia',
                'items'  => [
                    ['nama' => 'Videotron 5x2.5m',          'qty' => 1],
                    ['nama' => 'Speaker FOH Baretone 15RC',  'qty' => 2],
                    ['nama' => 'Mixer Yamaha MGP-24',        'qty' => 1],
                    ['nama' => 'TV LG 75 Time Keeper',       'qty' => 1],
                ],
            ],
            'streaming' => [
                'nama'   => 'Paket Streaming',
                'status' => 'tersedia',
                'items'  => [
                    ['nama' => 'Camcorder Sony',    'qty' => 1],
                    ['nama' => 'Atem Mini Pro',     'qty' => 1],
                    ['nama' => 'Capture Card HDMI', 'qty' => 1],
                    ['nama' => 'Tripod',            'qty' => 1],
                ],
            ],
            'listrik' => [
                'nama'   => 'Paket Listrik',
                'status' => 'tersedia',
                'items'  => [
                    ['nama' => 'Kabel Roll 5 Meter', 'qty' => 3],
                ],
            ],
            'komunikasi' => [
                'nama'   => 'Paket Komunikasi',
                'status' => 'tersedia',
                'items'  => [
                    ['nama' => 'Handy Talkie (HT) + Charger', 'qty' => 4],
                ],
            ],
        ];

        if (!array_key_exists($nama_paket, $packages)) {
            return response()->json([
                'error'   => 'Paket tidak ditemukan',
                'pesan'   => 'Paket yang tersedia: aula, streaming, listrik, komunikasi'
            ], 404);
        }

        $paket = $packages[$nama_paket];

        // Anggota 4 — logika status barang
        if ($paket['status'] === 'sedang diperbaiki') {
            $paket['pesan'] = 'Paket ini sedang tidak dapat dipinjam karena dalam perbaikan.';
        }

        return response()->json($paket, 200);
    }
}

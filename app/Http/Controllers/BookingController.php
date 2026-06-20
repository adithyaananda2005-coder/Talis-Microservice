<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessOrderJob;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // VALIDASI INPUT
        $validated = $request->validate([
            'nama'  => 'required|string|max:100',
            'nim'   => 'required|digits:10',
            'paket' => 'required|string'
        ]);

        // AMBIL DATA PAKET DARI DATABASE LOKAL
        $asset = DB::table('assets')
            ->where('key_paket', $validated['paket'])
            ->first();

        if (!$asset) {
            return response()->json([
                'error' => 'Paket tidak ditemukan',
            ], 404);
        }

        // DISPATCH JOB KE REDIS QUEUE
        ProcessOrderJob::dispatch($validated);

        // RESPONSE SUKSES
        return response()->json([
            'message'      => 'Booking berhasil',
            'peminjam'     => $validated['nama'],
            'nim'          => $validated['nim'],
            'paket'        => $validated['paket'],
            'detail_paket' => $asset
        ], 201);
    }
}

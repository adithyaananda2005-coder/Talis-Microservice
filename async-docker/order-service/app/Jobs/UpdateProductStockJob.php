<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateProductStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $productId;
    public int $quantity;

    public function __construct(string $productId, int $quantity)
    {
        $this->productId = $productId;
        $this->quantity  = $quantity;
    }

    public function handle(): void
    {
        try {
            $response = Http::timeout(5)->post(
                env('PRODUCT_SERVICE_URL') . '/products/' . $this->productId . '/update-stock',
                ['product_quantity' => $this->quantity]
            );

            Log::info('UpdateProductStockJob executed', [
                'product_id' => $this->productId,
                'quantity'   => $this->quantity,
                'response'   => $response->status(),
            ]);
        } catch (\Exception $e) {
            Log::error('UpdateProductStockJob failed', [
                'product_id' => $this->productId,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
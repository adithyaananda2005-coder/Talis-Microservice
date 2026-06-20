<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('key_paket')->unique(); // aula, streaming, listrik, komunikasi
            $table->string('status')->default('tersedia'); // tersedia / diperbaiki
            $table->timestamps();
        });

        Schema::create('asset_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('nama_barang');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_items');
        Schema::dropIfExists('assets');
    }
};
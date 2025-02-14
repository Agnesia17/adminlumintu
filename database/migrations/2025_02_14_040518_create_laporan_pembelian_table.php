<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_supplier');
            $table->string('nama_produk');
            $table->double('harga_beli');
            $table->double('jumlah');
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pembelian');
    }
};

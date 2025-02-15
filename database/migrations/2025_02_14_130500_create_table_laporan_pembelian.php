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
        Schema::create('table_laporan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_pembeli');
            $table->string('nama_produk');
            $table->double('harga_jual');
            $table->double('jumlah');
            $table->double('total');
            $table->foreignId('id_product')->constrained('product')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_laporan_pembelian');
    }
};

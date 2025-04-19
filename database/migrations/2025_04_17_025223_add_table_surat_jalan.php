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
        //
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_penerima', 255);
            $table->string('nama_produk', 100);
            $table->string('jenis_kendaraan', 100);
            $table->string('no_pol', 8);
            $table->double('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('surat_jalan');
    }
};

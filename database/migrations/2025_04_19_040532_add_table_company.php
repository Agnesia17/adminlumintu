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
        Schema::create('company', function (Blueprint $table) {
            //
            $table->id();
            $table->string('company', 255);
            $table->string('alamat_company', 255);
            $table->string('no_telp', 15);
            $table->string('owner', 100);
            $table->string('email_company', 100);
            $table->string('logo_company')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            //
            Schema::dropIfExists('company');
        });
    }
};

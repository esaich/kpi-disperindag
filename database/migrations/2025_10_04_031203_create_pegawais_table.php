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
    Schema::create('pegawais', function (Blueprint $table) {
        $table->id('pegawai_id');
        $table->string('nama');
        $table->unsignedBigInteger('bidang_id');
        $table->timestamps();

        $table->foreign('bidang_id')->references('bidang_id')->on('bidangs')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('pegawais');
}
};

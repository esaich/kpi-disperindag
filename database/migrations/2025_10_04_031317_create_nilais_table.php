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
    Schema::create('nilais', function (Blueprint $table) {
        $table->id('nilai_id');
        $table->unsignedBigInteger('pegawai_id');
        $table->unsignedBigInteger('indikator_id');
        $table->integer('nilai');
        $table->timestamps();

        $table->foreign('pegawai_id')->references('pegawai_id')->on('pegawais')->onDelete('cascade');
        $table->foreign('indikator_id')->references('indikator_id')->on('indikators')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('nilais');
}
};

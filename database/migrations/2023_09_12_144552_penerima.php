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
        Schema::create('m_penerima', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_kk');
            $table->string('nik');
            $table->string('no_telpon');
            $table->integer('tingkat_pendapatan');
            $table->integer('jumlah_anggota_keluarga');
            $table->integer('status_pekerjaan');
            $table->integer('kondisi_rumah');
            $table->integer('kondisi_kesehatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_penerima');
    }
};

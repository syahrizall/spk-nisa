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
        Schema::create('t_data_alternatif', function (Blueprint $table) {
            $table->id();
            $table->integer('penerima_id');
            $table->float('tingkat_pendapatan', 5, 3);
            $table->float('jumlah_anggota_keluarga', 5, 3);
            $table->float('status_pekerjaan', 5, 3);
            $table->float('kondisi_rumah', 5, 3);
            $table->float('kondisi_kesehatan', 5, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_data_alternatif');
    }
};

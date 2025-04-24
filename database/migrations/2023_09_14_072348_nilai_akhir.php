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
        Schema::create('t_nilai_akhir', function (Blueprint $table) {
            $table->id();
            $table->integer('peserta_id');
            $table->float('wiraga', 5, 3);
            $table->float('wirama', 5, 3);
            $table->float('wirasa', 5, 3);
            $table->float('nilai_akhir', 5, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_nilai_akhir');
    }
};

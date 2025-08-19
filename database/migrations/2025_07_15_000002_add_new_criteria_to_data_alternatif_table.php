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
        Schema::table('t_data_alternatif', function (Blueprint $table) {
            $table->float('pengalaman', 5, 3)->default(0)->after('wirasa');
            $table->float('ketidakhadiran', 5, 3)->default(0)->after('pengalaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_data_alternatif', function (Blueprint $table) {
            $table->dropColumn(['pengalaman', 'ketidakhadiran']);
        });
    }
};

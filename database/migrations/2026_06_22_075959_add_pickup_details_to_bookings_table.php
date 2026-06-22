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
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('total_price');
            $table->date('tanggal_ambil')->after('catatan');
            $table->time('jam_ambil')->after('tanggal_ambil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['catatan', 'tanggal_ambil', 'jam_ambil']);
        });
    }
};

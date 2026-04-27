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
        Schema::table('dkms', function (Blueprint $table) {
            // Tambah kolom relasi ke seksi
            if (!Schema::hasColumn('dkms', 'seksi_id')) {
                $table->unsignedBigInteger('seksi_id')->nullable()->after('id');

                // Foreign key (optional tapi disarankan)
                $table->foreign('seksi_id')
                      ->references('id')
                      ->on('seksi')
                      ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dkms', function (Blueprint $table) {
            if (Schema::hasColumn('dkms', 'seksi_id')) {
                $table->dropForeign(['seksi_id']);
                $table->dropColumn('seksi_id');
            }
        });
    }
};

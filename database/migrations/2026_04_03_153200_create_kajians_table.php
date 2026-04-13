<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kajians', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->string('judul');

            $table->foreignId('ustadz_id')
                ->constrained('ustadz')
                ->cascadeOnDelete();

            $table->foreignId('kitab_id')
                ->constrained('kitab')
                ->cascadeOnDelete();

            $table->enum('hari',['Jumat','Minggu']);
            $table->integer('pekan');
            $table->time('waktu');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kajians');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('video_kajians', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('pemateri');
            $table->string('video_id'); // YouTube video ID
            $table->string('thumbnail')->nullable();
            $table->string('durasi')->nullable(); // Format: HH:MM:SS
            $table->integer('views')->default(0);
            $table->string('kategori')->default('Kajian Islam');
            $table->string('sumber')->default('YouTube'); // Yufid TV, Rodja, dll
            $table->string('sumber_channel')->nullable(); // Channel YouTube
            $table->date('tanggal_upload')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['is_active', 'is_featured']);
            $table->index('kategori');
            $table->index('sumber');
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_kajians');
    }
};

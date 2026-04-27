<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kitab', function (Blueprint $table) {
            $table->string('judul')->nullable();
            $table->string('penulis')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->string('kategori')->default('Kitab Kajian');
            $table->string('bahasa')->default('Arab');
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->date('tanggal_terbit')->nullable();
            
            $table->index(['is_active', 'is_featured']);
            $table->index('kategori');
        });
    }

    public function down()
    {
        Schema::table('kitab', function (Blueprint $table) {
            $table->dropColumn([
                'judul',
                'penulis', 
                'deskripsi',
                'pdf_path',
                'cover_image',
                'jumlah_halaman',
                'kategori',
                'bahasa',
                'views',
                'is_featured',
                'is_active',
                'tanggal_terbit'
            ]);
        });
    }
};

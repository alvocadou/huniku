<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['rumah', 'kost', 'kontrakan', 'apartemen']);
            $table->enum('transaction_type', ['sewa', 'jual'])->default('sewa');
            $table->string('city');
            $table->string('district')->nullable();
            $table->unsignedBigInteger('price'); // harga sewa per unit waktu, atau harga jual total
            $table->enum('price_unit', ['bulan', 'tahun', 'hari', 'jual'])->default('bulan');
            $table->text('description')->nullable();
            $table->string('thumbnail_color')->default('teal'); // dipakai buat placeholder gradient di card
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
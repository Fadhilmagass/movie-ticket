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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('synopsis');
            $table->integer('duration'); // dalam menit
            $table->string('genre');
            $table->decimal('rating', 3, 1)->default(0); // 0 - 10
            $table->string('poster')->nullable();
            $table->string('trailer_url')->nullable();
            $table->date('release_date');
            $table->enum('status', ['coming_soon', 'now_showing'])->default('coming_soon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

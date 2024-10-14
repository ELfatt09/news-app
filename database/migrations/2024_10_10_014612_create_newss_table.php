<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');// Kolom untuk menyimpan body artikel dengan baris baru, nullable jika tidak ada konten
            $table->string('slug')->unique();
            $table->string('image_path')->nullable();
            $table->foreignId('author_id')->constrained('users');
            $table->integer('views')->default(0);
            $table->enum('category', ['Education', 'Politics', 'Economy', 'Technology', 'Health', 'Sports', 'Environment', 'Crime-&-Law', 'International', 'Entertainment', 'Science', 'Security', 'Transportation', 'Religion', 'Social-Issues']);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

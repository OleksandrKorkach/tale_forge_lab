<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('books_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->integer('sequence')->default(0);
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

        Schema::create('books_pages_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('block_type'); // Например, 'text', 'image', 'header'
            $table->text('content')->nullable(); // Содержимое блока, для изображений это может быть ссылка
            $table->integer('sequence')->default(0); // Порядок блока на странице
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('books_pages')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books_pages_blocks');
        Schema::dropIfExists('pages_blocks');
        Schema::dropIfExists('books');
    }
};

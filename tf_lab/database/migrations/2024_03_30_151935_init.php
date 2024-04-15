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
            $table->text('quote');
            $table->string('author_name');
            $table->string('season')->nullable();
            $table->integer('year')->nullable();
            $table->string('language')->nullable();
            $table->integer('pages')->default(0);
            $table->string('age_rating')->nullable();
            $table->float('community_rating')->nullable();
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('members')->default(0);
            $table->unsignedBigInteger('favorite_members')->default(0);

            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->integer('sequence')->default(0);
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

        Schema::create('page_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('block_type');
            $table->text('content')->nullable();
            $table->integer('sequence')->default(0);
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_blocks');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('books');
    }
};

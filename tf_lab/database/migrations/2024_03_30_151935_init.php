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
            $table->text('quote')->nullable();
            $table->string('author_name');
            $table->string('season')->nullable();
            $table->integer('year')->nullable();
            $table->string('language')->nullable();
            $table->integer('pages')->default(0);
            $table->string('age_rating')->nullable();
            $table->float('community_rating')->nullable();
            $table->boolean('is_published')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->text('url')->nullable();
            $table->unsignedBigInteger('members')->default(0);
            $table->unsignedBigInteger('favorite_members')->default(0);

            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->boolean('ai_generated')->default(false);

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('book_comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('username');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('number_of_likes')->default(0);
            $table->unsignedBigInteger('number_of_dislikes')->default(0);
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('book_comment_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('comment_id')->constrained('book_comments')->onDelete('cascade');
            $table->enum('type', ['like', 'dislike']);
            $table->timestamps();
        });

        Schema::create('book_genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('text_color');
            $table->string('background_color');
            $table->timestamps();
        });

        Schema::create('book_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained('book_genres')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('book_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('book_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('book_tags')->onDelete('cascade');
            $table->timestamps();
        });


        Schema::create('book_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('value');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('book_ratings');
        Schema::dropIfExists('book_tag');
        Schema::dropIfExists('book_tags');
        Schema::dropIfExists('book_genre');
        Schema::dropIfExists('book_genres');
        Schema::dropIfExists('book_comment_likes');
        Schema::dropIfExists('book_comments');
        Schema::dropIfExists('books');
    }
};

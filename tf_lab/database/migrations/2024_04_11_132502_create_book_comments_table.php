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
        Schema::create('book_comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('username');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('number_of_likes')->default(0);
            $table->unsignedBigInteger('number_of_dislikes')->default(0);
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_comments');
    }
};

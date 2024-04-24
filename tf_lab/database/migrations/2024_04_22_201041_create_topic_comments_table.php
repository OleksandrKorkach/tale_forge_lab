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
        Schema::create('topic_comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->string('author_name');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('comment_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('comment_id')
                ->references('id')->on('topic_comments')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_comments');
    }
};

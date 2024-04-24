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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('username');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('club_id')->nullable();
            $table->unsignedBigInteger('number_of_replies')->default(0);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('club_id')->references('id')->on('clubs');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};

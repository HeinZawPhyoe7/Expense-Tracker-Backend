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
        Schema::create('expense_trackers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('total_balance')->default(0)->nullable();
            $table->integer('income')->default(0)->nullable();
            $table->integer('expense')->default(0)->nullable();
            $table->string('type');
            $table->string('wallet');
            $table->string('expense_category');
            $table->date('date');
            $table->bigInteger('amount');
            $table->string('description');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_trackers');
    }
};

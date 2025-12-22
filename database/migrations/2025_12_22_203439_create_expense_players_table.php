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
        /* Quiénes pusieron dinero */
        Schema::create('expense_players', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expense_id');
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('paid_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_players');
    }
};

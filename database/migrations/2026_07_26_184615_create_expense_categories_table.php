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
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->nullable() //null for categories configured by seeders or admins.
                ->cascadeOnDelete(); //when a user is deleted, their personal expense categories are also deleted
            $table->unique(['user_id', 'name']); //no duplicate custom categories for the same user
            $table->string('icon', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};

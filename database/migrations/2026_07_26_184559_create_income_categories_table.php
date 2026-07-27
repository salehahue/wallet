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
        Schema::create('income_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->nullable() //null for categories configured by seeders or admins.
                ->cascadeOnDelete(); //when a user is deleted, their personal income sources are also deleted
            $table->unique(['user_id', 'name']); //no duplicate custom categories for the same user
            $table->string('icon', 255)->nullable();
            $table->timestamps();
        });
    }
/*
⚠️ One important caveat
Because user_id is nullable,
MySQL allows multiple rows where user_id = NULL, even with a unique index.
So this is still possible:
Salary | NULL
Salary | NULL

If your system categories are only inserted through
seeders or an admin interface with validation,
this isn't a practical problem.
Just be aware that the database alone won't stop duplicate system categories
 */
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_categories');
    }
};

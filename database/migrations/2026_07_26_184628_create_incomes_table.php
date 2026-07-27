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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('income_category_id')
                ->references('id')
                ->on('income_categories')
                ->restrictOnDelete();/*Deleting the category should be prevented unless all related incomes are reassigned or removed. Explained in end*/
            $table->string('title', 150);
            $table->decimal('amount', 12, 2);
            $table->date('received_at');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();/*No column in parameter cuz $table->softDeletes(); automatically creates this: deleted_at TIMESTAMP NULL , whenever executed*/
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
/*Imagine Salary already has 300 income records. An admin tries to delete Salary
Should Laravel allow it?
No.
Those 300 records still need a valid category.
 */

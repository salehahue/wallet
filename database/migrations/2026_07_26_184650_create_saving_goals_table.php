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
        Schema::create('saving_goals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title', 150);

            $table->text('description')->nullable();

            $table->enum('goal_type', [
                'fixed',
                'percentage',
            ]);

            $table->decimal('target_value', 12, 2);

            $table->enum('period', [
                'monthly',
                'one_time',
            ]);

            $table->date('target_date')->nullable();

            $table->enum('status', [
                'active',
                'completed',
                'expired',
            ])->default('active');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_goals');
    }
};

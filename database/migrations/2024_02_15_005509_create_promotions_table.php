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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('user_id')->constrained('users');
            $table->string('reason');
            $table->date('date_of_promotion');
            $table->string('old_department');
            $table->string('new_department');
            $table->string('old_grade');
            $table->string('new_grade');
            $table->string('old_designation');
            $table->string('new_designation');
            $table->decimal('old_salary');
            $table->decimal('new_salary');
            $table->date('date_of_promotion');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->foreign('employee_id')->constrained('employees')->nullable();
            $table->date('date_start');
            $table->date('date_end');
            $table->string('type');
            $table->string('title');
            $table->string('reason');
            $table->string('status');
            $table->string('priority');
            $table->string('attachment');
            $table->string('department');
            $table->date('designation');
            $table->string('grade');
            $table->string('office');
            $table->string('company');
            $table->string('location');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};

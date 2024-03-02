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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->String('title');
            $table->String('description');
            $table->dateTime('start_Date');
            $table->dateTime('end_Date');
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->enum('status', ['todo','progress','done',]);
            $table->String('location');
            $table->String('type');
            $table->foreignId('department_id')->nullable()->constrained();
            $table->foreignId('employee_id')->references('user_id')->on('clients')->onDelete('cascade');
            $table->foreignId('client_id')->references('user_id')->on('clients')->onDelete('cascade');
            $table->foreignId('partner_id')->references('user_id')->on('partners')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

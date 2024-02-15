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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type_of_business');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->integer('phone');
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('address');
            $table->string('postal_code');
            $table->string('description');
            $table->string('video');
            $table->string('map');
            $table->string('slogan');
            $table->string('banner');
            $table->string('logo');
            $table->string('about');
            $table->string('mission');
            $table->string('vision');
            $table->enum('status' , ['active' , 'inactive'])->default('active');
            $table->foreignId('project_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};

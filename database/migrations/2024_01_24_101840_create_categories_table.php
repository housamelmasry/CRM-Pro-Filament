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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                                        ->nullable() // nullable must be set before constrained
                                        ->constrained('categories','id')
                                        ->nullOnDelete();   // if i deleted item have relationship it convert relation column to null and converting child to main item
                                        // ->cascadeOnDelete()  // to delete items and all children
                                        // ->restrictOnDelete(); // cannot delete if item have children and its defult already if i didn't write one from the top
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status',['active','archived',]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

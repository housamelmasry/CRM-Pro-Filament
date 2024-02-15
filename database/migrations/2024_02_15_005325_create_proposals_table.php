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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('financial_notes');
            $table->string('payment_terms');
            $table->string('offer_validity');
            $table->string('delivery_terms');
            $table->foreignId('product_id')->constrained();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('partner_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 8, 2);
            $table->string('discount')->nullable();
            $table->decimal('value_vat', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('note')->nullable();
            $table->date('proposal_date');
            $table->date('delivery_date');
            $table->date('payment_date');
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};

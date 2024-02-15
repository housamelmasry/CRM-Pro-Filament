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
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('invoice_id')->constrained();
            $table->foreign('invoice_number')->references('invoice_number')->on('invoices');
            // $table->unsignedBigInteger('id_Invoice');
            // $table->string('invoice_number', 50);
            $table->foreignId('client_id')->constrained();
            $table->foreignId('department_id')->nullable()->constrained();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('proposal_id')->nullable()->constrained();
            $table->foreignId('employee_id')->nullable()->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('payment_id')->nullable()->constrained();
            $table->foreignId('partner_id')->nullable()->constrained();
            $table->string('product_name', 999);
            $table->decimal('quantity', 8, 2);
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('department', 999);
            // $table->string('Status', 50);
            $table->integer('value_status');
            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices_details');
    }
};

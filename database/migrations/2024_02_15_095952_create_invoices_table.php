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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('proposal_id')->nullable()->constrained('proposals');
            $table->foreignId('employee_id')->nullable()->constrained('employees');
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('invoice_id')->constrained('invoice_attachments')->nullable();
            $table->foreignId('payment_id')->nullable()->constrained('payments');
            $table->foreignId('partner_id')->nullable()->constrained('partners');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('discount')->nullable();
            $table->string('rate_vat');
            $table->decimal('value_vat',8,2);
            $table->decimal('total',8,2);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->enum('payment_status',['paid','partial','unpaid'])->default('unpaid');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

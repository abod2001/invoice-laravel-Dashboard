<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 50);
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('product', 50);
            $table->bigInteger('section_id' )->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('amount_collection',8,2)->nullable();;
            $table->decimal('amount_commission',8,2);
            $table->decimal('discount',8,2);
            $table->decimal('value_VAT',8,2);
            $table->string('rate_VAT', 999);
            $table->decimal('total',8,2);
            $table->string('status', 50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}

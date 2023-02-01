<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_subs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices');

            $table->string('name');
            $table->float('qty')->default(0);
            $table->double('amount', 12,2)->default(0);
            $table->double('total_amount', 12,2)->default(0);
            $table->double('tax_amount', 12,2)->default(0);
            $table->double('net_amount', 12,2)->default(0);
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
        Schema::dropIfExists('invoice_subs');
    }
};

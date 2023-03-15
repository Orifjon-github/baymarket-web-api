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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("OrderID");
            $table->string('ClientName');
            $table->string("Phone");
            $table->enum('Type', ["delivery", 'pick up'])->default('pick up');
            $table->text('Address')->nullable();
            $table->integer("Postcode")->nullable();
            $table->string("Time")->nullable();
            $table->enum("PaymentType", ['debit card', 'cash'])->default('cash');
            $table->text("Comment")->nullable();
            $table->float("TotalPrice");
            $table->enum("Status", ['Not Confirmed', 'Confirmed', 'Canceled', 'Delivered', 'Pick uped'])->default('Not Confirmed');
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
        Schema::dropIfExists('orders');
    }
};

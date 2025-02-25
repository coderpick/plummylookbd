<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number',20);
            $table->unsignedBigInteger('user_id');
            //$table->foreign('user_id')->references('id')->on('users');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->double('amount')->nullable();
            $table->float('shipping',10,2)->nullable();
            $table->string('discount')->nullable();
            $table->string('advance')->default(0);
            $table->integer('point_pay')->nullable();
            $table->longText('address')->nullable();
            $table->unsignedBigInteger('district_id');
            $table->string('zip');
            $table->longText('transaction_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamp('date');
            $table->enum('payment_status',['paid','unpaid','failed','canceled'])->default('unpaid');
            $table->enum('payment_type',['cash','gateway'])->default('cash');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

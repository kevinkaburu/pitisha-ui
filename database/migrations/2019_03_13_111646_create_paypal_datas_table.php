<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status_code');
            $table->string('status');
            $table->string('order_id');
            $table->string('payment_id');
            $table->string('custom_id');
            $table->string('payer_given_name');
            $table->string('payer_sur_name');
            $table->string('currency');
            $table->double('amount');
            $table->string('payee_email');
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
        Schema::dropIfExists('paypal_datas');
    }
}

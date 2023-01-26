<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone_number')->nullable();
            $table->string('txn_id')->nullable();
            $table->uuid('txn_ref')->nullable();
            $table->string('flw_ref')->nullable();
            $table->string('currency')->nullable();
            $table->double('amount_charged', 12, 2)->nullable();
            $table->double('app_fee', 12, 2)->nullable();
            $table->double('merchant_fee', 12, 2)->nullable();
            $table->double('amount_settled', 12, 2)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

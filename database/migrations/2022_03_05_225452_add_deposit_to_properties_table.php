<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepositToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->double('deposit_cost', 11, 2)->after('rent_cost')->nullable();
            $table->json('other_costs')->after('status')->nullable();
            $table->json('meta')->after('other_costs')->nullable();
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedInteger('deposit_months')->after('rent_cost')->default(1);
            $table->json('meta')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('deposit_cost');
            $table->dropColumn('other_costs');
            $table->dropColumn('meta');
        });

        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('deposit_months');
            $table->dropColumn('meta');
        });
    }
}

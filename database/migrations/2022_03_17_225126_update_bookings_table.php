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
        Schema::table('bookings', function (Blueprint $table) {
             $table->renameColumn('is_confirmed', 'admin_confirmed');
             $table->dropColumn('status');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->after('admin_confirmed', function (Blueprint $table) {
                $table->boolean('landlord_confirmed')->default(false);
                $table->unsignedSmallInteger('status')->default(0);
            });
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
            $table->renameColumn('admin_confirmed', 'is_confirmed');
            $table->dropColumn('landlord_confirmed');
            $table->dropColumn('status');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('status')->after('admin_confirmed')->default('booked');
        });
    }
};

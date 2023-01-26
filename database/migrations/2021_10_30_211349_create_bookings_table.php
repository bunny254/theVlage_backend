<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('number_of_guests')->default(1);
            $table->double('price', 11, 2);
            $table->double('rent_cost', 11, 2)->nullable();
            $table->double('amenities_cost', 11, 2)->nullable();
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->foreignUuid('author_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('property_id')
                ->constrained('properties')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->boolean('is_confirmed')->default(false);
            $table->string('status')->default('booked');
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
        Schema::dropIfExists('bookings');
    }
}

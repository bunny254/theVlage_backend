<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('listing_type');
            $table->string('building_type');
            $table->string('name');
            $table->string('unit_size')->nullable();
            $table->string('stay_type');
            $table->boolean('is_furnished');
            $table->double('rent_cost', 11, 2);
            $table->double('utilities_cost', 11, 2)->default(0.00);
            $table->string('currency');
            $table->unsignedInteger('bedrooms');
            $table->unsignedInteger('bathrooms');
            $table->string('location');
            $table->string('description', 10000);
            $table->string('cover_image')->nullable();
            $table->json('amenities')->nullable();
            $table->string('status')->default('pending');
            $table->date('available_from');
            $table->dateTime('date_approved')->nullable();
            $table->double('longitude', 11, 8)->nullable();
            $table->double('latitude', 11, 8)->nullable();
            $table->foreignUuid('author_id')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('approved_by')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('properties');
    }
}

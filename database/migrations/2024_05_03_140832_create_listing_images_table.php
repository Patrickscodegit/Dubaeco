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
        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();  // Creates an auto-incrementing primary key column named 'id'.
            $table->foreignId('listing_id') // Creates an unsigned bigint column for storing listing IDs.
                ->constrained('listings')  // Defines a foreign key that references the 'id' column of the 'listings' table.
                ->onDelete('cascade');  // Specifies that deleting a listing should delete all associated images.
            $table->string('image_path');  // Creates a column to store the image file path.
            $table->timestamps();  // Creates 'created_at' and 'updated_at' columns.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_images');  // Defines how to reverse the migration (drops the table).
    }
};

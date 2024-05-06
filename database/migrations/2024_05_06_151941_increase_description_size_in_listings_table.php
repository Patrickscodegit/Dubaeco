<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseDescriptionSizeInListingsTable extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->mediumText('description')->change();
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('description', 255)->change(); // Assuming it was VARCHAR(255) before.
        });
    }
}

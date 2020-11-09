<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamps();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 10, 8);
            $table->decimal('north_latitude', 10, 8);
            $table->decimal('south_latitude', 10, 8);
            $table->decimal('east_longitude', 10, 8);
            $table->decimal('west_longitude', 10, 8);
            $table->decimal('cross_distance', 10, 8);
            $table->char('issue', 255);
            $table->char('solution', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments');
    }
}

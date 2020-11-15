<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePerchCurrentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_perches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->timestamps();
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('ip_latitude', 11, 8);
            $table->decimal('ip_longitude', 11, 8);
            $table->decimal('north_latitude', 11, 8);
            $table->decimal('south_latitude', 11, 8);
            $table->decimal('east_longitude', 11, 8);
            $table->decimal('west_longitude', 11, 8);
            $table->decimal('cross_distance', 11, 8);
            $table->decimal('ip_issue_distance', 11, 8);
            $table->string('social_compass', 6);
            $table->string('economic_compass', 6);
            $table->string('compass_color', 6);
            $table->string('issue', 255);
            $table->string('solution', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

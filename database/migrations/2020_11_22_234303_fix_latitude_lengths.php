<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixLatitudeLengths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('current_perches', function($table)
        {
            $table->decimal('latitude', 10, 8)->change();
            $table->decimal('ip_latitude', 10, 8)->change();
            $table->decimal('north_latitude', 10, 8)->change();
            $table->decimal('south_latitude', 10, 8)->change();
        });
        Schema::table('perches', function($table)
        {
            $table->decimal('latitude', 10, 8)->change();
            $table->decimal('ip_latitude', 10, 8)->change();
            $table->decimal('north_latitude', 10, 8)->change();
            $table->decimal('south_latitude', 10, 8)->change();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPerchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perches', function($table)
        {
            if (Schema::hasColumn('perches', 'social_compass'))
            {
                $table->dropColumn('social_compass');
            }
            if (Schema::hasColumn('perches', 'economic_compass'))
            {
                $table->dropColumn('economic_compass');
            }
            if (Schema::hasColumn('perches', 'compass_color'))
            {
                $table->dropColumn('compass_color');
            }
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

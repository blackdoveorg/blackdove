<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPerchCurrent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('current_perches', function($table)
        {
            if (Schema::hasColumn('perches', 'social_compass'))
            {
                $table->dropColumn('social_compass');
                $table->decimal('social_compass', 4, 2);
            }
            if (Schema::hasColumn('perches', 'economic_compass'))
            {
                $table->dropColumn('economic_compass');
                $table->decimal('economic_compass', 4, 2);
            }
            if (Schema::hasColumn('perches', 'compass_color'))
            {
                $table->dropColumn('compass_color');
                $table->char('compass_color', 6);
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

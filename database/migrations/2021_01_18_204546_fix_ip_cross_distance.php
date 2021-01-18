<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixIpCrossDistance extends Migration
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
            $table->decimal('ip_issue_distance', 13, 8)->change();
        });
        Schema::table('perches', function($table)
        {
            $table->decimal('ip_issue_distance', 13, 8)->change();
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

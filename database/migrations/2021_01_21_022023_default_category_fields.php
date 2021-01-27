<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefaultCategoryFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perches', function(Blueprint $table)
        {
            $table->dropColumn('issue_category');
            $table->dropColumn('solution_category');
        });
        Schema::table('current_perches', function(Blueprint $table)
        {
            $table->dropColumn('issue_category');
            $table->dropColumn('solution_category');
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

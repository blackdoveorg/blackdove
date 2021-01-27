<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeCategoryJson extends Migration
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
        Schema::table('perches', function (Blueprint $table) {
            $table->json('issue_category')->default('');
            $table->json('solution_category')->default('');
        });
        Schema::table('current_perches', function (Blueprint $table) {
            $table->json('issue_category')->default('');
            $table->json('solution_category')->default('');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoriesAgainWithDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perches', function (Blueprint $table) {
            $table->char('issue_category', 255)->default('');
            $table->char('solution_category', 255)->default('');
        });
        Schema::table('current_perches', function (Blueprint $table) {
            $table->char('issue_category', 255)->default('');
            $table->char('solution_category', 255)->default('');
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

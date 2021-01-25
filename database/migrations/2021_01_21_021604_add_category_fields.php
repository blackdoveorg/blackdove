<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perches', function (Blueprint $table) {
            $table->char('issue_category', 255);
            $table->char('solution_category', 255);
        });
        Schema::table('current_perches', function (Blueprint $table) {
            $table->char('issue_category', 255);
            $table->char('solution_category', 255);
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

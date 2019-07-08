<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TzHelpCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tz_help_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("parent_id");
            $table->string("name",255);
            $table->string("seo_title",255);
            $table->string("seo_description",255);
            $table->string("seo_keywords",255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tz_help_category');
    }
}

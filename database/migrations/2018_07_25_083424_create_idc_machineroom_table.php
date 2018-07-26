<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdcMachineroomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idc_machineroom', function (Blueprint $table) {
            $table->increments('id')->comment('id');
            $table->string('machine_room_id', 25)->comment('机房编号');
            $table->string('machine_room_name', 50)->comment('机房中文名');
            $table->float('list_order',0,0)->default(10000)->comment('排序');
            $table->softDeletes();
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
        Schema::dropIfExists('idc_machineroom');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dbrequests', function (Blueprint $table) {
            $table->string('servicename');
            $table->string('engine');
            $table->smallInteger('requestedcpu');
            $table->smallInteger('requestedmemory');
            $table->text('requesteddisk');
            $table->text('requestedvip');
            $table->boolean('vmstatus');
            $table->string('requestedby');
            $table->string('installed');
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
        Schema::dropIfExists('dbrequests');
    }
}

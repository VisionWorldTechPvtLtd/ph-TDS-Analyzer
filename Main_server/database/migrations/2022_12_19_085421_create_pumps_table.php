<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pumps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('pump_title');
            $table->string('serial_no')->nullable();
            $table->date('last_calibration_date');
            $table->string('pipe_size')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('flow_limit')->nullable();
            $table->string('imei_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('u_key')->nullable();
            $table->boolean('panel_lock')->default('0')->comment('0 - unlock 1 - lock');
            $table->boolean('on_off_status')->default('2')->comment('2 - off 3 - on');
            $table->boolean('external')->default('0')->comment('0 - internal 1 - external');
            $table->boolean('auto_manual')->default('0')->comment('0 - auto 1 - manual');
            $table->boolean('live_data')->default('0')->comment('0 - live 1 - static');
            $table->boolean('tested')->default('0')->comment('0 - untested 1 - tested');
            $table->boolean('visiable')->default('0')->comment('0 - visible 1 - hidden');
            $table->integer('plan_id')->nullable();
            $table->date('plan_start_date')->nullable();
            $table->date('plan_end_date')->nullable();
            $table->boolean('plan_status')->nullable()->comment('0 - ongoing 1 - expired');
            $table->text('address')->nullable();
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
        Schema::dropIfExists('pumps');
    }
};

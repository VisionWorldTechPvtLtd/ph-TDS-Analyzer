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
        Schema::create('sims', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('pump_id')->nullable();
            $table->foreign('pump_id')->references('id')->on('pumps')->onDelete('cascade');
            $table->string('sim_company')->nullable();
            $table->string('sim_imei')->nullable();
            $table->string('sim_number');
            $table->string('sim_name')->nullable();
            $table->boolean('sim_type')->default('0')->comment('2 - data 3 - m2m');
            $table->boolean('sim_active')->default('0')->comment('1 - active 0 - deactivate');
            $table->date('sim_purchase')->nullable();
            $table->date('sim_start')->nullable();
            $table->date('sim_end')->nullable();
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
        Schema::dropIfExists('sims');
    }
};

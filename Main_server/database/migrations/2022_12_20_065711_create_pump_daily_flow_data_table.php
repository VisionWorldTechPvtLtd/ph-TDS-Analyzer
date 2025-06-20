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
        Schema::create('pump_daily_flow_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pump_id'); 
            $table->foreign('pump_id')->references('id')->on('pumps')->onDelete('cascade');
            $table->float('forward_flow')->default(0);
            $table->float('reverse_flow')->default(0);
            $table->float('ground_water_level')->default(0); 
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
        Schema::dropIfExists('pump_daily_flow_data');
    }
};

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
        Schema::create('haryanaapi', function (Blueprint $table) {
            $table->id('api_id');
            $table->unsignedBigInteger('b_id');
            $table->foreign('b_id')->references('id')->on('pumps')->onDelete('cascade');
            $table->string('nocnumber', 50);
            $table->string('userkey', 50); 
            $table->string('companyname', 500);
            $table->string('abstructionstructurenumber', 50);
            $table->double('latitude', 50); 
            $table->double('longitude', 50); 
            $table->string('vendorfirmsname', 200);
            $table->boolean('sensor')->default(0)->comment('1 - piezometer, 2 - flowmeter');
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
        Schema::dropIfExists('haryanaapi');
    }
};

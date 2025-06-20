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
        Schema::create('s_t_p__data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stp_id')->comment('A');
            $table->foreign('stp_id')->references('id')->on('s_t_p_s')->onDelete('cascade');
            $table->float('cod')->default(0)->comment('B');
            $table->float('bod')->default(0)->comment('C');
            $table->float('toc')->default(0)->comment('D');
            $table->float('tss')->default(0)->comment('E');
            $table->float('ph')->default(0)->comment('F');
            $table->float('temperature')->default(0)->comment('G');
            $table->string('h')->nullable()->comment('H');
            $table->string('i')->nullable()->comment('I');
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
        Schema::dropIfExists('s_t_p__data');
    }
};

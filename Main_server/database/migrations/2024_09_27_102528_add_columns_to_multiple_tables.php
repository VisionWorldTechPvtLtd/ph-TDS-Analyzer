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
        Schema::table('pumps', function (Blueprint $table) {
                $table->boolean('piezometer')->default(0)->comment('1 - piezometer, 0 - borewell')->after('panel_lock');
        });
        Schema::table('pumps', function (Blueprint $table) {
            $table->float('today_flow')->default(0)->after('piezometer');
    });

        Schema::table('users', function (Blueprint $table) {
        $table->float('user_flow_limit')->default(0)->after('status');

        });

        Schema::table('pump_daily_flow_data', function (Blueprint $table) {
            $table->float('totalizer')->default(0)->after('ground_water_level');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pumps', function (Blueprint $table) {
                $table->dropColumn('piezometer');

        });
        Schema::table('pumps', function (Blueprint $table) {
            $table->dropColumn('today_flow');

    });

        Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('user_flow_limit');

        });
        Schema::table('pump_daily_flow_data', function (Blueprint $table) {
            $table->dropColumn('totalizer');

    });
    }
};

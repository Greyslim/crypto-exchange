<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cryptocurrency_tokens')->insert([
            ["name" => "Bitcoin", "short_name" => "BTC","sys_id" => 1],
            ["name" => "Tether", "short_name" => "USDT", "sys_id" => 825],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cryptocurrency_tokens')->where("sys_id" ,1)->delete();
        DB::table('cryptocurrency_tokens')->where("sys_id" ,825)->delete();
    }
};

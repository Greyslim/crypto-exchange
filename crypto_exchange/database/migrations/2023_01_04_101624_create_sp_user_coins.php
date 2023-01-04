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
        $procedure = 
"
DROP PROCEDURE IF EXISTS sp_user_coins;

CREATE 
PROCEDURE sp_user_coins(IN p_user_id int)
BEGIN
    SELECT uct.id, ct.name, ct.short_name, uct.amount  FROM user_cryptocurrency_tokens uct 
    LEFT OUTER JOIN cryptocurrency_tokens ct ON uct.cryptocurrency_token_id = ct.id
    WHERE uct.user_id = p_user_id;
END;
";
        \DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $procedure = 
"
DROP PROCEDURE IF EXISTS sp_user_coins;
";
        \DB::unprepared($procedure);
    }
};

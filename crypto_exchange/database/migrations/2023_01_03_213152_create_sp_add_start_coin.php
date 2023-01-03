<?php

use Illuminate\Database\Migrations\Migration;
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
DROP PROCEDURE IF EXISTS sp_add_start_coin;

CREATE 
PROCEDURE sp_add_start_coin(IN p_user_id int)
BEGIN
    INSERT INTO user_cryptocurrency_tokens (user_id, cryptocurrency_token_id, amount, created_at, updated_at)
    VALUES (p_user_id, (SELECT ct.id FROM cryptocurrency_tokens ct WHERE ct.name = 'Bitcoin' LIMIT 1), 0.001,  NOW(), NOW());

    INSERT INTO user_cryptocurrency_tokens (user_id, cryptocurrency_token_id, amount, created_at, updated_at)
    VALUES (p_user_id, (SELECT ct.id FROM cryptocurrency_tokens ct WHERE ct.name = 'Tether' LIMIT 1), 1,  NOW(), NOW());
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
DROP PROCEDURE IF EXISTS sp_add_start_coin;
";
        \DB::unprepared($procedure);
    }
};

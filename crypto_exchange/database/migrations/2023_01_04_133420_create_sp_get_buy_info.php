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
DROP PROCEDURE IF EXISTS sp_get_buy_info;

CREATE DEFINER = 'root'@'%'
PROCEDURE sp_get_buy_info(IN p_user_id int, IN p_user_coin_id int)
BEGIN
  DECLARE check_user_id int;
  DECLARE p_json_info json;

  SELECT uct.user_id INTO check_user_id
  FROM user_cryptocurrency_tokens uct 
  WHERE uct.id = p_user_coin_id LIMIT 1;

  IF(check_user_id = p_user_id) THEN
    SELECT ct.short_name AS coin_name_to,
      ct1.short_name AS coin_name_from,
      CONCAT('Price ',ct1.short_name,'=>',ct.short_name) AS caption_price,
      CAST(rct.price AS decimal(18,10)) AS price,
      CONCAT('Amount ',ct.short_name) AS caption_amount_to,
      uct.amount AS amount_to,
      CONCAT('Amount ',ct1.short_name) AS caption_amount_from,
      uct1.amount AS amount_from
    FROM user_cryptocurrency_tokens uct 
    LEFT OUTER JOIN relation_cryptocurrency_token rct ON uct.cryptocurrency_token_id = rct.cryptocurrency_token_to_id
    LEFT OUTER JOIN cryptocurrency_tokens ct ON rct.cryptocurrency_token_to_id = ct.id
    LEFT OUTER JOIN cryptocurrency_tokens ct1 ON rct.cryptocurrency_token_from_id = ct1.id
    LEFT OUTER JOIN user_cryptocurrency_tokens uct1 ON uct1.user_id = uct.user_id AND uct1.cryptocurrency_token_id = ct1.id
    WHERE uct.id = p_user_coin_id; 
  ELSE
    SET @help = '';
  END IF;
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
DROP PROCEDURE IF EXISTS sp_get_buy_info;
";
        \DB::unprepared($procedure);
    }
};

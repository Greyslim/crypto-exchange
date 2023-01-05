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
DROP PROCEDURE IF EXISTS sp_buy_coin;

CREATE DEFINER = 'root'@'%'
PROCEDURE sp_buy_coin(IN p_json longtext)
lbl:BEGIN
  DECLARE p_coin_name_to, p_coin_name_from varchar(511);
  DECLARE p_price, p_amount double(27,10);
  DECLARE p_user_id int;

  DECLARE p_coin_name_to_id, p_coin_name_from_id bigint; -- ID in system
  DECLARE p_price_from, p_price_to double(27,10); -- Price in World
  DECLARE p_user_coin_from, p_user_coin_to double(27,10); -- Coin in user wallet

  DECLARE p_user_coin_from_later, p_user_coin_to_later double(27,10);

  DECLARE p_coin_params_id bigint;
  DECLARE p_change_percent double(27,10) DEFAULT '0.01';

  SELECT 
    JSON_UNQUOTE(JSON_EXTRACT(p_json,'$.coin_name_to')),
    JSON_UNQUOTE(JSON_EXTRACT(p_json,'$.coin_name_from')),
    JSON_UNQUOTE(JSON_EXTRACT(p_json,'$.price')),
    JSON_UNQUOTE(JSON_EXTRACT(p_json,'$.amount')),
    JSON_UNQUOTE(JSON_EXTRACT(p_json,'$.user_id'))
  INTO
    p_coin_name_to, -- Что покупаю
    p_coin_name_from, -- За что
    p_price,
    p_amount,
    p_user_id;

  SELECT ct.id INTO p_coin_name_to_id FROM cryptocurrency_tokens ct WHERE ct.short_name = p_coin_name_to;
  SELECT ct.id INTO p_coin_name_from_id FROM cryptocurrency_tokens ct WHERE ct.short_name = p_coin_name_from;

  SELECT rct.price INTO p_price_to FROM relation_cryptocurrency_token rct 
  WHERE rct.cryptocurrency_token_to_id = p_coin_name_to_id AND rct.cryptocurrency_token_from_id = p_coin_name_from_id;

  SELECT rct.price INTO p_price_from FROM relation_cryptocurrency_token rct 
  WHERE rct.cryptocurrency_token_to_id = p_coin_name_from_id AND rct.cryptocurrency_token_from_id = p_coin_name_to_id;

  SELECT uct.amount, uct.id INTO p_user_coin_to, p_coin_params_id FROM user_cryptocurrency_tokens uct WHERE uct.cryptocurrency_token_id = p_coin_name_to_id AND uct.user_id = p_user_id;
  SELECT uct.amount INTO p_user_coin_from FROM user_cryptocurrency_tokens uct WHERE uct.cryptocurrency_token_id = p_coin_name_from_id AND uct.user_id = p_user_id;


  -- Validate
  SET p_user_coin_to_later = p_amount + p_user_coin_to;
  SET p_user_coin_from_later = p_user_coin_from - p_amount*p_price;

  IF(p_amount<=0) THEN
    select JSON_OBJECT('code','403','msg','Amount must be a positive','id',p_coin_params_id) AS p_data;
    LEAVE lbl;
  END IF;


  IF(ABS(1 - p_price_to/p_price)>p_change_percent) THEN
    select JSON_OBJECT('code','403','msg','The price has changed a lot','id',p_coin_params_id) AS p_data;
    LEAVE lbl;
  END IF;


  IF (p_user_coin_to_later >= 0 AND p_user_coin_from_later>=0) THEN
    UPDATE  user_cryptocurrency_tokens uct 
    SET uct.amount = p_user_coin_to_later
    WHERE uct.cryptocurrency_token_id = p_coin_name_to_id AND uct.user_id = p_user_id;

    UPDATE  user_cryptocurrency_tokens uct 
    SET uct.amount = p_user_coin_from_later
    WHERE uct.cryptocurrency_token_id = p_coin_name_from_id AND uct.user_id = p_user_id;

    select JSON_OBJECT('code','200','msg','','id',p_coin_params_id) AS p_data;
  ELSE
    select JSON_OBJECT('code','403','msg','insufficient funds','id',p_coin_params_id) AS p_data;
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
DROP PROCEDURE IF EXISTS sp_buy_coin;
";
        \DB::unprepared($procedure);
    }
};

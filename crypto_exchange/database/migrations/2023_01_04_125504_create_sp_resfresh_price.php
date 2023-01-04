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
DROP PROCEDURE IF EXISTS sp_resfresh_price;

CREATE DEFINER = 'root'@'%'
PROCEDURE sp_resfresh_price(IN p_json longtext)
BEGIN
  DECLARE BTC_id, USDT_id, relation_cryptocurrency_token_id int;
  DECLARE coin_price double;

  SELECT ct.id INTO BTC_id FROM cryptocurrency_tokens ct WHERE ct.short_name = 'BTC';
  SELECT ct.id INTO USDT_id FROM cryptocurrency_tokens ct WHERE ct.short_name = 'USDT';

  IF(JSON_VALID(p_json)) THEN
    SELECT id INTO relation_cryptocurrency_token_id 
    FROM relation_cryptocurrency_token 
    WHERE cryptocurrency_token_to_id = BTC_id AND cryptocurrency_token_from_id = USDT_id LIMIT 1;

    SET coin_price = JSON_EXTRACT(p_json,'$.BTC.USDT');
    IF (relation_cryptocurrency_token_id IS NULL) THEN
      INSERT INTO relation_cryptocurrency_token(cryptocurrency_token_to_id, cryptocurrency_token_from_id, price)
      VALUES (BTC_id, USDT_id, coin_price);
    ELSE
      UPDATE relation_cryptocurrency_token
      SET price = coin_price
      WHERE id = relation_cryptocurrency_token_id;
    END IF;

    SET relation_cryptocurrency_token_id = NULL;
    SELECT id INTO relation_cryptocurrency_token_id 
    FROM relation_cryptocurrency_token 
    WHERE cryptocurrency_token_to_id = USDT_id AND cryptocurrency_token_from_id = BTC_id LIMIT 1;

    SET coin_price = JSON_EXTRACT(p_json,'$.USDT.BTC');
    IF (relation_cryptocurrency_token_id IS NULL) THEN
      INSERT INTO relation_cryptocurrency_token(cryptocurrency_token_to_id, cryptocurrency_token_from_id, price)
      VALUES (USDT_id, BTC_id, coin_price);
    ELSE
      UPDATE relation_cryptocurrency_token
      SET price=coin_price
      WHERE id = relation_cryptocurrency_token_id;
    END IF;
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
DROP PROCEDURE IF EXISTS sp_resfresh_price;
";
        \DB::unprepared($procedure);
    }
};

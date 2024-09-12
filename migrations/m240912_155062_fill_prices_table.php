<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tonnages}}`.
 */
class m240912_155062_fill_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        
       INSERT INTO prices (tonnage_id, month_id, raw_type_id, price)
SELECT
    t.id AS tonnage_id,
    m.id AS month_id,
    r.id AS raw_type_id,
    FLOOR(100 + RAND() * 100) AS price -- генерируем случайное значение цены в диапазоне от 100 до 200
FROM
    tonnages t
JOIN
    months m
JOIN
    raw_types r;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tonnages}}');
    }
}

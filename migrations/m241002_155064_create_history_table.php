<?php

use yii\db\Migration;


class m241002_155064_create_history_table extends Migration
{
    public function safeUp()

    {
        $this->execute("
        
                CREATE TABLE history (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                id_user INT(11) UNSIGNED NOT NULL,
                date DATE NOT NULL,
                time TIME NOT NULL,
                months VARCHAR(20) NOT NULL,
                tonnage FLOAT NOT NULL,
                raw_type VARCHAR(10) NOT NULL,
                price DECIMAL(10, 2) NOT NULL)
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%history}}'); 
    }
}

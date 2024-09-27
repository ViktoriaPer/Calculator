<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tonnages}}`.
 */
class m240912_155061_fill_raw_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        
        INSERT INTO raw_types (name) VALUES ('шрот'), ('соя'), ('жмых');
)
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
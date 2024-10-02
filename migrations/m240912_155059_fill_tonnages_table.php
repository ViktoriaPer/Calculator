<?php

use yii\db\Migration;


class m240912_155059_fill_tonnages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        
INSERT INTO tonnages (value) VALUES (25), (50), (75), (100)
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

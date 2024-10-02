<?php

use yii\db\Migration;


class m240912_155060_fill_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        
        INSERT INTO months (name) VALUES
('январь'), ('февраль'), ('март'), ('апрель'), ('май'), ('июнь'),
('июль'), ('август'), ('сентябрь'), ('октябрь'), ('ноябрь'), ('декабрь')
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%months}}');
    }
}

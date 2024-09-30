<?php

use yii\db\Migration;


class m240930_155064_fill_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    //Для каждого пользователя - юзернейм уникален, почта тоже должна быть уникальна
    public function safeUp()
    {
        $this->execute("
        
       INSERT INTO user (username, email, password, role)
       VALUES ('Admin', 'Admin@efko.ru', 'Admin123', 'admin');
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}'); 
    }
}

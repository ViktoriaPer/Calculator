<?php

use yii\db\Migration;


class m240930_155063_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    //Для каждого пользователя - юзернейм уникален, почта тоже должна быть уникальна
    public function safeUp()
    {
        $this->execute("
        
       CREATE TABLE user (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(75) NOT NULL UNIQUE,
    email varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    role varchar(255) NOT NULL DEFAULT 'user'
)
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

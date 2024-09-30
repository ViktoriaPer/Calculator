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
        $password = Yii::$app->security->generatePasswordHash('Admin123');
    
        $this->execute("
            INSERT INTO user (username, email, password, role)
            VALUES ('Admin', 'Admin@efko.ru', '$password', 'admin');
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

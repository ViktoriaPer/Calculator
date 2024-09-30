<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'user'; //Достать таблицу из БД с помощью ActiveRecord
    }
    
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username', 'email', 'password'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'unique'], // Уникальность email
            [['username'], 'unique'], // Уникальность username
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Автоматически назначаем роль 'user'
                $this->role = 'user';
            }
            return true;
        }
        return false;
    }
}
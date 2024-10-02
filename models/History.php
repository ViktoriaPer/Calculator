<?php

namespace app\models;

use yii\db\ActiveRecord;

class History extends ActiveRecord
{
    public static function tableName()
    {
        return 'history'; //Достать таблицу из БД с помощью ActiveRecord
    }
}
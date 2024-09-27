<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tonnage extends ActiveRecord
{
    public static function tableName()
    {
        return 'tonnages'; //Достать таблицу из БД с помощью ActiveRecord
    }
}
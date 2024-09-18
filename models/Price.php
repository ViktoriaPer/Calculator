<?php

namespace app\models;

use yii\db\ActiveRecord;

class Price extends ActiveRecord
{
    public static function tableName()
    {
        return 'prices'; //Достать таблицу из БД с помощью ActiveRecord
    }
}
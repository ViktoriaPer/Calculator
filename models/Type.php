<?php

namespace app\models;

use yii\db\ActiveRecord;

class Type extends ActiveRecord
{
    public static function tableName()
    {
        return 'raw_types'; //Достать таблицу из БД с помощью ActiveRecord
    }
}
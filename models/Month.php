<?php

namespace app\models;

use yii\db\ActiveRecord;

class Month extends ActiveRecord
{
    public static function tableName()
    {
        return 'months'; //Достать таблицу из БД с помощью ActiveRecord
    }
}
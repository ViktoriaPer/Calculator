<?php

namespace app\models;

use app\models\User;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'user'; //Достать таблицу из БД с помощью ActiveRecord
    }

}
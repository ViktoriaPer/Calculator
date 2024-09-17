php
<?php

namespace app\models;

use yii\db\ActiveRecord;

class Month extends ActiveRecord
{
    public static function tableName()
    {
        return 'months'; // Название таблицы в базе данных
    }
}
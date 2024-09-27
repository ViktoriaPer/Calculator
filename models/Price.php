<?php

namespace app\models;

use app\models\Price;
use app\models\Month;
use app\models\Type;
use app\models\Tonnage;
use yii\db\ActiveRecord;

class Price extends ActiveRecord
{
    public static function tableName()
    {
        return 'prices'; //Достать таблицу из БД с помощью ActiveRecord
    }

    // Связь с моделью Tonnage
    public function getTonnage()
    {
        return $this->hasOne(Tonnage::class, ['id' => 'tonnage_id']);
    }

    // Связь с моделью Month
    public function getMonth()
    {
        return $this->hasOne(Month::class, ['id' => 'month_id']);
    }

    // Связь с моделью Type
    public function getRawType()
    {
        return $this->hasOne(Type::class, ['id' => 'raw_type_id']);
    }


}
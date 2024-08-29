<?php

namespace app\models;

use yii\base\Model;

class CalculationForm extends Model
{
    public $month;

    public $tonnage;

    public $type;

    public function attributeLabels(): array
    {
        return [
            'month' => 'Месяц',
            'tonnage' => 'Тоннаж',
            'type' => 'Тип сырья',
        ];
    }

    public function rules(): array
    {
        return [
            [
                [
                    'month',
                    'tonnage',
                    'type',
                ],
                'required',
                'message' => 'Необходимо выбрать значение поля {attribute}',
            ],
        ];
    }
}
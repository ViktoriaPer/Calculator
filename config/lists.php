<?php
namespace App\Config;


class Lists
{

public static function getLists()
{
return [
    'months'=>
    [
        'январь',
        'февраль',
        'август',
        'сентябрь',
        'октябрь',
        'ноябрь',
    ],
    'tonnages'=>
    [
        25,
        50,
        75,
        100,
    ],

    'raw_types'=>
    [
        'соя',
        'шрот',
        'жмых',
    ],
];
}
}
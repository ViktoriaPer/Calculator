<?php
namespace app\models;

use yii\db\Connection;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\models\{Price, Month, Type, Tonnage};


class PricesRepository
{

        public function handleGet(): array
    {
   
        // Получение всех цен для всех типов сырья
        $allPrices =[
            'шрот' => [
                'январь' => [
                    50 => 145,
                    75 => 136,
                    100 => 138
                ],
                'февраль' => [
                    50 => 118,
                    75 => 137,
                    100 => 142
                ],
                'август' => [
                    50 => 119,
                    75 => 141,
                    100 => 117
                ],
                'сентябрь' => [
                    50 => 121,
                    75 => 137,
                    100 => 124
                ],
                'октябрь' => [
                    50 => 122,
                    75 => 131,
                    100 => 147
                ],
                'ноябрь' => [
                    50 => 147,
                    75 => 143,
                    100 => 112
                ]
            ],
            'жмых' => [
                'январь' => [
                    25 => 121,
                    50 => 118,
                    75 => 137,
                    100 => 142
                ],
                'февраль' => [
                    25 => 137,
                    50 => 121,
                    75 => 124,
                    100 => 131
                ],
                'август' => [
                    25 => 124,
                    50 => 145,
                    75 => 136,
                    100 => 138
                ],
                'сентябрь' => [
                    25 => 137,
                    50 => 147,
                    75 => 143,
                    100 => 112
                ],
                'октябрь' => [
                    25 => 122,
                    50 => 143,
                    75 => 112,
                    100 => 117
                ],
                'ноябрь' => [
                    25 => 125,
                    50 => 145,
                    75 => 136,
                    100 => 138
                ]
            ],
            'соя' => [
                'январь' => [
                    25 => 137,
                    50 => 147,
                    75 => 112,
                    100 => 122
                ],
                'февраль' => [
                    25 => 125,
                    50 => 145,
                    75 => 136,
                    100 => 138
                ],
                'август' => [
                    25 => 124,
                    50 => 145,
                    75 => 136,
                    100 => 138
                ],
                'сентябрь' => [
                    25 => 122,
                    50 => 143,
                    75 => 112,
                    100 => 117
                ],
                'октябрь' => [
                    25 => 137,
                    50 => 119,
                    75 => 141,
                    100 => 117
                ],
                'ноябрь' => [
                    25 => 121,
                    50 => 118,
                    75 => 137,
                    100 => 142
                ]
            ]
        ];

        return $allPrices;
    }

    public function isPriceExists(string $month, int $tonnage, string $type): bool
    {
        $prices=$this->handleGet();
        return isset($prices[$type][$month][$tonnage]);
    }

    public function getPrice(string $month, int $tonnage, string $type): int
    {
        $prices=$this->handleGet();
        return $prices[$type][$month][$tonnage];
    }

    public function getPriceListTonnagesByRawType(string $type): array
    {
        $prices=$this->handleGet();
        $firstMonth = array_key_first($prices[$type]);

        return array_keys($prices[$type][$firstMonth]);
    }

    public function getPriceListMonthsByRawType(string $type): array
    {
        $prices=$this->handleGet();
        return array_keys($prices[$type]);
    }

    public function getPriceListPriceByRawTypeAndMonth(string $type, string $month): array
    {
        $prices=$this->handleGet();
        return $prices[$type][$month];
    }

    public function getPriceListByRawType(string $type): array
    {
        $prices=$this->handleGet();
        return $prices[$type];
    }

}
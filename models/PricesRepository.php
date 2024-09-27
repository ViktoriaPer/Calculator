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
        // Получаем все цены из базы данных
        $allPrices = Price::find()
            ->with(['tonnage', 'month', 'rawType']) // Подгружаем связанные данные
            ->all();
    
        $result = [];
    
        // Определяем порядок месяцев
        $monthsOrder = [
            'январь' => 1,
            'февраль' => 2,
            'март' => 3,
            'апрель' => 4,
            'май' => 5,
            'июнь' => 6,
            'июль' => 7,
            'август' => 8,
            'сентябрь' => 9,
            'октябрь' => 10,
            'ноябрь' => 11,
            'декабрь' => 12,
        ];
    
        // Упорядочиваем данные по типам сырья, месяцам и тоннажу
        foreach ($allPrices as $price) {
            $rawTypeName = $price->rawType->name; // Название типа сырья
            $monthName = $price->month->name; // Название месяца
            $tonnageValue = $price->tonnage->value; // Значение тоннажа
            $priceValue = $price->price; // Значение цены
    
            // Убедимся, что ключ для типа сырья существует
            if (!isset($result[$rawTypeName])) {
                $result[$rawTypeName] = [];
            }
    
            // Убедимся, что ключ для месяца существует
            if (!isset($result[$rawTypeName][$monthName])) {
                $result[$rawTypeName][$monthName] = [];
            }
    
            // Заполняем цену по тоннажу
            $result[$rawTypeName][$monthName][$tonnageValue] = $priceValue;
        }
    
        // Сортируем месяцы по правильному порядку
        foreach ($result as &$rawTypePrices) {
            // Сортируем массив по месяцам используя порядок, заданный в $monthsOrder
            uksort($rawTypePrices, function ($a, $b) use ($monthsOrder) {
                return $monthsOrder[$a] <=> $monthsOrder[$b];
            });
        }
    
        return $result;
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

        var_dump($prices[$type][$firstMonth]);
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
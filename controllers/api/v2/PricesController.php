<?php

namespace app\controllers\api\v2;
use app\models\Price; //модели
use app\models\Month;
use app\models\Tonnage;
use app\models\Type;
class PricesController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        return [
            'class' => \app\components\filters\TokenAuthMiddleware::class,
            'verbFilter' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                ],
            ],
        ];
    }

    public function actionIndex(): array
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        // Переменные, которые хранят значение из запроса
        $type = mb_strtolower(\Yii::$app->request->get('type'));
        $monthName = mb_strtolower(\Yii::$app->request->get('month'));
        $tonnageValue = \Yii::$app->request->get('tonnage');
        
        // Проверка на наличие необходимых параметров
        if (empty($type) || empty($monthName) || empty($tonnageValue)) {
            return [
                'error' => 'Ошибка, не указан один из параметров.',
            ];
        }
    
        // Получение ID для месяца и тоннажа
        $monthId = Month::find()->where(['name' => $monthName])->select('id')->scalar();
        $tonnageId = Tonnage::find()->where(['value' => $tonnageValue])->select('id')->scalar();
    
        // Подготовка базового запроса
        $Pricelist = Price::find();
    
        // Добавляем фильтры по типу
        if ($type) {
            $typeId = Type::find()->where(['name' => $type])->select('id')->scalar();
            if ($typeId !== null) {
                $Pricelist->andWhere(['raw_type_id' => $typeId]);
            }
        }
    
        // Получаем конкретную цену для выбранных параметров
        $selectedPrice = Price::find()
            ->where(['raw_type_id' => $typeId, 'month_id' => $monthId, 'tonnage_id' => $tonnageId])
            ->one();
    
        $priceValue = $selectedPrice ? $selectedPrice->price : null;
    
        // Если цена не найдена
        if ($priceValue === null) {
            return [
                'error' => 'Цена не найдена.',
            ];
        }
    
        // Запрос всех цен, которые соответствуют типу
        $prices = $Pricelist->all();
    
        // Массив результата
        $result = [];
        foreach ($prices as $price) {
            $monthName = Month::find()->select('name')->where(['id' => $price->month_id])->scalar();
            $tonnageValue = Tonnage::find()->select('value')->where(['id' => $price->tonnage_id])->scalar();
            $rawTypeName = Type::find()->select('name')->where(['id' => $price->raw_type_id])->scalar();
    
            // Проверяем, совпадает ли тип сырья с запрашиваемым
            if (mb_strtolower($rawTypeName) === $type) {
                $result[] = [
                    'month' => $monthName,  // Добавляем название месяца
                    'tonnage' => $tonnageValue,  // Добавляем значение тоннажа
                    'price' => $price->price,
                ];
            }
        }
    
        // Сортировка месяцев
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
    
        usort($result, function ($a, $b) use ($monthsOrder) {
            return $monthsOrder[$a['month']] <=> $monthsOrder[$b['month']];
        });
    
        return [
            'price' => $priceValue, // Добавляем цену, соответствующую запросу
            'price_list' => [
                "$rawTypeName" => $result,
            ],
        ];
    }


}
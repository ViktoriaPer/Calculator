<?php

namespace app\controllers\api\v2;
use app\models\Price; //Подключила модели
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
    
        // Переменные, которые хранят значение из запроса постмана
        $type = mb_strtolower(\Yii::$app->request->get('type'));
        $monthName = mb_strtolower(\Yii::$app->request->get('month'));
        $tonnageValue = \Yii::$app->request->get('tonnage');
        
        //Если что-то из параметров пустое - выдаст соотв. сообщение
        if (empty($type) || empty($monthName) || empty($tonnageValue)) {
            return [
                'error' => 'Ошибка, не указан один из параметров.',
            ];
        }
    
        // Получение ID для месяца и тоннажа из моделек
        $monthId = Month::find()->where(['name' => $monthName])->select('id')->scalar();
        $tonnageId = Tonnage::find()->where(['value' => $tonnageValue])->select('id')->scalar();
    
        //Заполнение прайслиста ВСЕМИ ценами
        $Pricelist = Price::find();
    
        //Прайслист для выбранного типа сырья
        if ($type) {
            $typeId = Type::find()->where(['name' => $type])->select('id')->scalar();
            if ($typeId !== null) {
                $Pricelist->andWhere(['raw_type_id' => $typeId]);
            }
        }
    
        //Цена по параметрам
        $selectedPrice = Price::find()
            ->where(['raw_type_id' => $typeId, 'month_id' => $monthId, 'tonnage_id' => $tonnageId])
            ->one();
    
        //поиск нужной цены
        $priceValue = $selectedPrice ? $selectedPrice->price : null;
    
        //Ошибка, если нет такой цены в прайсе
        if ($priceValue === null) {
            return [
                'error' => 'Цена не найдена.',
            ];
        }
    
        //Выкачка всех цен для посл. сортировки
        $prices = $Pricelist->all();
    
        //формирование правильного результата
        $result = [];
        foreach ($prices as $price) {
            $monthName = Month::find()->select('name')->where(['id' => $price->month_id])->scalar();
            $tonnageValue = Tonnage::find()->select('value')->where(['id' => $price->tonnage_id])->scalar();
            $rawTypeName = Type::find()->select('name')->where(['id' => $price->raw_type_id])->scalar();
    
            //Если тип сырья совпал:
            if (mb_strtolower($rawTypeName) === $type) {
                $result[] = [
                    
                    'month' => $monthName,  // Добавляем название месяца
                    'tonnage' => $tonnageValue,  // Добавляем значение тоннажа
                    'price' => $price->price,
                ];
            }
        }
    
        //Божественная сортировка месяцев
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
    
        //сортировочка
        usort($result, function ($a, $b) use ($monthsOrder) {
            return $monthsOrder[$a['month']] <=> $monthsOrder[$b['month']];
        });
    
        return [
            'price' => $priceValue, //Цена по запросу
            'price_list' => [
                "$rawTypeName" => $result,
            ],
        ];
    }


}
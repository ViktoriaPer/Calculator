<?php

namespace app\controllers\api\v2;

use app\models\Price;
use app\models\Month;
use app\models\Type;
use app\models\Tonnage;
use yii\web\Response;

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
                    'index' => ['GET', 'POST', 'PATCH', 'DELETE'],
                ],
            ],
        ];
    }

    public function actionIndex(): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        switch (\Yii::$app->request->method) {
            case 'GET':
                return $this->handleGet();
            case 'POST':
                return $this->handleCreate();
            case 'PATCH':
                return $this->handleUpdate();
            case 'DELETE':
                return $this->handleDelete();
            default:
                return ['message' => 'Метод не поддерживается.'];
        }
    }

    public function handleGet(): array
    {
        $monthName = \Yii::$app->request->get('month');
        $rawTypeName = \Yii::$app->request->get('type');
        $tonnageValue = \Yii::$app->request->get('tonnage');
        
        // Получение необходимых данных
        $month = Month::find()->where(['name' => $monthName])->one();
        $tonnage = Tonnage::find()->where(['value' => $tonnageValue])->one();
        $rawType = Type::find()->where(['name' => $rawTypeName])->one(); 
    
        if (!$month || !$tonnage || !$rawType) {
            return ['message' => 'Ошибка: месяц, тоннаж или тип сырья не найдены.'];
        }
    
        // Получение цены по заданным параметрам
        $priceItem = Price::find()
            ->where(['month_id' => $month->id, 'raw_type_id' => $rawType->id, 'tonnage_id' => $tonnage->id])
            ->one();
    
        // Получение всех цен для указанного типа сырья
        $allPrices = Price::find()
            ->where(['raw_type_id' => $rawType->id])
            ->with(['tonnage', 'month'])
            ->all();
    
        $result = [
            'price' => $priceItem ? $priceItem->price : null,
            'price_list' => [],
        ];
    
        // Массив для правильного порядка месяцев
        $monthOrder = [
            'январь', 'февраль', 'март', 'апрель', 'май', 
            'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'
        ];
    
        // Формирование списка цен
        foreach ($allPrices as $price) {
            $monthName = $price->month->name;
            $tonnageValue = $price->tonnage->value;
            
            // Добавление данных в массив результатов
            if (!isset($result['price_list'][$price->rawType->name][$monthName])) {
                $result['price_list'][$price->rawType->name][$monthName] = [];
            }
            
            $result['price_list'][$price->rawType->name][$monthName][$tonnageValue] = $price->price;
        }
    
        // Упорядочивание месяцев
        $orderedPriceList = [];
        foreach ($monthOrder as $monthName) {
            if (isset($result['price_list'][$rawType->name][$monthName])) {
                $orderedPriceList[$rawType->name][$monthName] = $result['price_list'][$rawType->name][$monthName];
            }
        }
    
        $result['price_list'] = $orderedPriceList;
    
        return $result;
    }
    public function handleCreate(): array
    {
        $data = \Yii::$app->request->bodyParams;

        $rawTypeName = isset($data['raw_type']) ? $data['raw_type'] : null; 
        $monthName = isset($data['month']) ? $data['month'] : null;
        $tonnageValue = isset($data['tonnage']) ? $data['tonnage'] : null;
        $priceValue = isset($data['price']) ? $data['price'] : null;

        if ($rawTypeName === null || $monthName === null || $tonnageValue === null || $priceValue === null) {
            return ['message' => 'Ошибка: не указаны все параметры.'];
        }

        $month = Month::find()->where(['name' => $monthName])->one();
        $tonnage = Tonnage::find()->where(['value' => $tonnageValue])->one();

        if (!$month || !$tonnage) {
            return ['message' => 'Ошибка: месяц или тоннаж не найдены.'];
        }

        $price = new Price();
        $price->month_id = $month->id;
        $price->raw_type_id = $rawTypeName; 
        $price->tonnage_id = $tonnage->id;
        $price->price = $priceValue;

        if ($price->validate() && $price->save()) {
            return ['message' => 'Цена успешно добавлена.'];
        } else {
            \Yii::error("Ошибка валидации: " . json_encode($price->errors), __METHOD__);
            return ['message' => 'Ошибка при добавлении цены.'];
        }
    }

    public function handleUpdate(): array
    {
        $monthName = \Yii::$app->request->get('month');
        $rawTypeName = \Yii::$app->request->get('raw_type'); 
        $tonnageValue = \Yii::$app->request->get('tonnage');

        $data = \Yii::$app->request->bodyParams;
        $priceValue = isset($data['price']) ? $data['price'] : null;

        if ($priceValue === null) {
            return ['message' => 'Ошибка: не указана цена.'];
        }

        $month = Month::find()->where(['name' => $monthName])->one();
        $tonnage = Tonnage::find()->where(['value' => $tonnageValue])->one();

        if (!$month || !$tonnage) {
            return ['message' => 'Ошибка: месяц или тоннаж не найдены.'];
        }


        $price = Price::find()
            ->where(['month_id' => $month->id, 'raw_type_id' => $rawTypeName, 'tonnage_id' => $tonnage->id])
            ->one();

        if (!$price) {
            return ['message' => 'Ошибка: цена не найдена.'];
        }

        $price->price = $priceValue;

        if ($price->validate() && $price->save()) {
            return ['message' => 'Цена успешно обновлена.'];
        } else {
            \Yii::error("Ошибка валидации: " . json_encode($price->errors), __METHOD__);
            return ['message' => 'Ошибка при обновлении цены.'];
        }
    }

    public function handleDelete(): array
    {
        $monthName = \Yii::$app->request->get('month');
        $rawTypeName = \Yii::$app->request->get('raw_type'); 
        $tonnageValue = \Yii::$app->request->get('tonnage');

        $month = Month::find()->where(['name' => $monthName])->one();
        $tonnage = Tonnage::find()->where(['value' => $tonnageValue])->one();

        if (!$month || !$tonnage) {
            return ['message' => 'Ошибка: месяц или тоннаж не найдены.'];
        }


        $price = Price::find()
            ->where(['month_id' => $month->id, 'raw_type_id' => $rawTypeName, 'tonnage_id' => $tonnage->id])
            ->one();

        if (!$price) {
            return ['message' => 'Ошибка: цена не найдена.'];
        }

        if ($price->delete()) {
            return ['message' => 'Цена успешно удалена.'];
        } else {
            return ['message' => 'Ошибка при удалении цены.'];
        }
    }
}

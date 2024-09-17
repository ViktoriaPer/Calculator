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

        //Переменные, которые хранят значение из запроса в Postman
        $month = mb_strtolower(\Yii::$app->request->get('month'));
        $type = mb_strtolower(\Yii::$app->request->get('type'));
        $tonnage =(\Yii::$app->request->get('tonnage'));

        // Создаем запрос к базе данных для получения цен
        $Pricelist = Price::find();

        // Добавляем фильтры по параметрам
        if ($month) {
            $Pricelist->andWhere(['month_id' => Month::find()->where(['name' => $month])->select('id')]);
        }
        if ($type) {
            $Pricelist->andWhere(['raw_type_id' => Type::find()->where(['name' => $type])->select('id')]);
        }
        if ($tonnage) {
            $Pricelist->andWhere(['tonnage_id' => Tonnage::find()->where(['value' => $tonnage])->select('id')]);
        }

        //Запрос
        $prices = $Pricelist->all();

        //Массив результата
        $result = [];
        foreach ($prices as $price) 

        {
            $result[] = 
            [
                'id' => $price->id,
                'tonnage_id' => $price->tonnage_id,
                'month_id' => $price->month_id,
                'raw_type_id' => $price->raw_type_id,
                'price' => $price->price,
            ];
        }

        return $result;
    }
}
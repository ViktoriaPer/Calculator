<?php

namespace app\controllers\api\v1;

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

        //Подключение массива из params.php
        $prices = \Yii::$app->params['prices'];

        
        // Проверка наличия данных и возврат цены
        if (isset($prices[$type][$month][$tonnage])) {
            return [
                'price' => $prices[$type][$month][$tonnage],
                'price_list'=>[
                    "$type" => $prices[$type],
                ],
            ];
        } else {
    
            return [
                'message' => "Стоимость для выбранных параметров отсутствует",
            ];
        } 
     
    }
}
<?php

namespace app\controllers\api\v2;
use app\models\Tonnage; //модель
class TonnagesController extends \yii\web\Controller
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

        //достать данные базы данных из модели
        $tonnages = Tonnage::find()->all();

        //Результат
        $result = [];
        foreach ($tonnages as $tonnage) {
            $result[] = $tonnage->value; 
        }

        return $result;
    }
}
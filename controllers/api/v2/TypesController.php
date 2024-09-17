<?php

namespace app\controllers\api\v2;
use app\models\Type; //модель
class TypesController extends \yii\web\Controller
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
        $raw_types = Type::find()->all();

        //Результат
        $result = [];
        foreach ($raw_types as $raw_type) {
            $result[] = $raw_type->name; 
        }

        return $result;
    }
}
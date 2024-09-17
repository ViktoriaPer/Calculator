<?php

namespace app\controllers\api\v1;
use app\models\Month; // Подключаем модель
class MonthsController extends \yii\web\Controller
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

        // Извлекаем данные из базы данных
        $months = Month::find()->all();

        // Формируем массив с результатами
        $result = [];
        foreach ($months as $month) {
            $result[$month->id] = $month->name; // id как ключ, name как значение
        }

        return $result;
    }
}
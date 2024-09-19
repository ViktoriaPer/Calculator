<?php

namespace app\controllers\api\v2;
use app\models\Month; //модель
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
                    'delete' => ['DELETE'],
                    'create' => ['POST'], 
                ],
            ],
        ];
    }

    public function actionIndex(): array
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        //достать данные базы данных из модели
        $months = Month::find()->all();

        //Результат
        $result = [];
        foreach ($months as $month) {
            $result[] = $month->name; 
        }

        return $result;
    }

    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Получаем данные из POST-запроса
        $name = Yii::$app->request->post('name');


        // Проверка на существование месяца с таким именем
        $existingMonth = Month::find()->where(['name' => $name])->one();
        if ($existingMonth !== null) {
            return [
                'message' => 'Ошибка: месяц с таким именем уже существует.',
            ];
        }

        // Создаем новый объект месяца
        $month = new Month();
        $month->name = $name;

        // Сохраняем месяц в базе данных
        if ($month->save()) {
            return [
                'message' => 'Месяц успешно добавлен.',
            ];
        }
            return [
                'message' => 'Ошибка при добавлении месяца.',
            ];
        
    }

    public function actionDelete(string $name): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Находим месяц по имени
        $month = Month::find()->where(['name' => $name])->one();

        // Удаляем месяц
        if ($month->delete()) {
            return [
                'message' => 'Месяц успешно удален.',
            ];
        }
        return [
                'message' => 'Ошибка при удалении месяца.',
                ];
        
    }
}
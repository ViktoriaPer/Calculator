<?php

namespace app\controllers\api\v2;
use app\models\Month; //модель
use yii\web\Response; // Добавляем класс для ответов
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
                    'index' => ['GET', 'DELETE','POST'],
                ],
            ],
        ];
    }

    public function actionIndex(): array
    {
        //установить формат респонса
        \Yii::$app->response->format = Response::FORMAT_JSON;

        switch (\Yii::$app->request->method) {
            case 'GET':
                return $this->handleGet();
    
            case 'POST':
                return $this->handleCreate();
    
            case 'DELETE':
                $month = \Yii::$app->request->get('month'); // Получаем параметр month из URL
                return $this->handleDelete($month); // Параметр month из адреса передается в метод удаления как name
    
            //на случай ошибки метода
            default:
                return ['message' => 'Метод не поддерживается.'];
        }
    }

    public function handleGet(): array
    {
        //Получаем данные из бд через модель
        $months = Month::find()->all();

        //вывод результата
        $result = [];
        foreach ($months as $month) {
            $result[] = $month->name; 
        }

        return $result;
    }

    public function handleCreate(): array
    {
        // Извлекаем данные из входящего запроса
        $data = array_map(function($value) {
            return is_string($value) ? mb_strtolower($value, 'UTF-8') : $value;
        }, \Yii::$app->request->bodyParams);

        // Извлекаем значение месяца из запроса
        $monthName = isset($data['month']) ? ($data['month']) : null;

        // Проверяем, указано ли имя месяца
        if ($monthName === null || $monthName === '') {
            return [
                'message' => 'Ошибка: имя месяца не указано.'
            ];
        }

        // Массив существующих названий месяцев
        $validMonths = [
            'январь', 'февраль', 'март', 'апрель', 'май', 'июнь',
            'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'
        ];

        // Проверяем, является ли введенное имя месяца действительным
        if (!in_array($monthName, $validMonths)) {
            return [
                'message' => 'Ошибка: такого месяца не существует.'
            ];
        }

        // Проверяем, существует ли уже месяц с таким названием
        if (Month::find()->where(['name' => $monthName])->exists()) {
            return [
                'message' => 'Ошибка: месяц с таким названием уже существует.'
            ];
        }

        // Создаем новую модель месяца
        $month = new Month();
        $month->name = $monthName; // Присваиваем значение полю name в модели

        // Проверка на корректность данных и попытка сохранения
        if ($month->validate() && $month->save()) {
            return [
                'message' => 'Месяц успешно добавлен.'
            ];
        } else {
            \Yii::error("Ошибка валидации: " . json_encode($month->errors), __METHOD__);
            return [
                'message' => 'Ошибка при добавлении месяца.'
            ];
        }
    }


    public function handleDelete(string $name): array
    {
        // Находим месяц по имени
        $month = Month::find()->where(['name' => $name])->one();

        if ($month === null) {
            return [
                'message' => 'Ошибка: месяц не найден.',
            ];
        }

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
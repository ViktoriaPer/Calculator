<?php

namespace app\controllers\api\v2;
use app\models\Tonnage; 
use yii\web\Response; 
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
                    'index' => ['GET', 'DELETE','POST'],
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
    
            case 'DELETE':
                $tonnage = \Yii::$app->request->get('tonnage'); 
                return $this->handleDelete($tonnage); 
            default:
                return ['message' => 'Метод не поддерживается.'];
        }
    }


    public function handleGet(): array
    {

        $tonnages = Tonnage::find()->all();


        $result = [];
        foreach ($tonnages as $tonnage) {
            $result[] = $tonnage->value; 
        }

        return $result;
    }

    public function handleCreate(): array
    {

        $data = \Yii::$app->request->bodyParams;
    

        $tonnageValue = isset($data['tonnage']) ? ($data['tonnage']) : null;
    

        if ($tonnageValue === null || $tonnageValue === '') {
            return [
                'message' => 'Ошибка: значение тоннажа не указано'
            ];
        }
    

        if (Tonnage::find()->where(['value' => $tonnageValue])->exists()) {
        return [
            'message' => 'Ошибка: такой тоннаж уже существует'
        ];
         }


        $tonnage = new Tonnage();
        $tonnage->value = $tonnageValue; 
    

        if ($tonnage->validate() && $tonnage->save()) {
            return [
                'message' => 'Тоннаж успешно добавлен.'
            ];
        } else {
            \Yii::error("Ошибка валидации: " . json_encode($month->errors), __METHOD__);
            return [
                'message' => 'Ошибка при добавлении тоннажа.'
            ];
        }
    }

    public function handleDelete(string $value): array
    {

        $tonnage = Tonnage::find()->where(['value' => $value])->one();

        if ($tonnage === null) {
            return [
                'message' => 'Ошибка: тоннаж не найден.',
            ];
        }


        if ($tonnage->delete()) {
            return [
                'message' => 'Тоннаж успешно удален.',
            ];
        }
        return [
            'message' => 'Ошибка при удалении тоннажа.',
        ];
    }


}
<?php

namespace app\controllers\api\v2;
use app\models\Type;
use yii\web\Response;
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
                $type = \Yii::$app->request->get('type'); 
                return $this->handleDelete($type); 
            default:
                return ['message' => 'Метод не поддерживается.'];
        }
    }

    public function handleGet(): array
    {

        $types = Type::find()->all();


        $result = [];
        foreach ($types as $type) {
            $result[] = $type->name; 
        }

        return $result;
    }

    public function handleCreate(): array
    {

        $data = \Yii::$app->request->bodyParams;
    

        $typeName = isset($data['type']) ? ($data['type']) : null;
    

        if ($typeName === null || $typeName === '') {
            return [
                'message' => 'Ошибка: имя сырья не указано'
            ];
        }
    

        if (Type::find()->where(['name' => $typeName])->exists()) {
        return [
            'message' => 'Ошибка: такой тип сырья уже существует'
        ];
         }


        $type = new Type();
        $type->name = $typeName; 
    

        if ($type->validate() && $type->save()) {
            return [
                'message' => 'Тип сырья успешно добавлен.'
            ];
        } else {
            \Yii::error("Ошибка валидации: " . json_encode($month->errors), __METHOD__);
            return [
                'message' => 'Ошибка при добавлении сырья.'
            ];
        }
    }

    public function handleDelete(string $name): array
    {

        $type = Type::find()->where(['name' => $name])->one();

        if ($type === null) {
            return [
                'message' => 'Ошибка: тип сырья не найден.',
            ];
        }


        if ($type->delete()) {
            return [
                'message' => 'Тип сырья успешно удален.',
            ];
        }
        return [
            'message' => 'Ошибка при удалении типа сырья.',
        ];
    }
}
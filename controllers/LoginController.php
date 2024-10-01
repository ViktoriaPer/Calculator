<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\LoginForm;

class LoginController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionIndex()
    {
        $model = new LoginForm();

        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack(); // Если вход успешен
        }
    
        return $this->render('index', [
            'model' => $model, // Возвращаем модель для вывода ошибок
        ]);
    }
    

}
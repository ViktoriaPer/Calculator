<?php

namespace app\controllers;

use yii\web\Controller;

class LogoutController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['/calculator']);
    }
    

}
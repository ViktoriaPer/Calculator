<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class AccountController extends Controller
{
    public function actionIndex()
    {
        // Получаем текущего пользователя
        $user = Yii::$app->user->identity;

        // Параметры профиля передаем в представление
        return $this->render('index', [
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->getRole(),
        ]);
    }
}
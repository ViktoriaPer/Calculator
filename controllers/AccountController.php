<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\User;

class AccountController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        }

        $user = Yii::$app->user->identity;

        // Параметры профиля передаем в представление
        return $this->render('index', [
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->getRole(),
        ]);
    }
}
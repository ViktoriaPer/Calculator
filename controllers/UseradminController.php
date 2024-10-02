<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class UseradminController extends Controller
{
    public function actionIndex()
    {
        //проверка на наличие прав администратора
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->getRole() !== 'admin') {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        }

        //провайдер данных для отображения пользователей в таблице
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use app\models\History;

class HistoryController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        }

        $userId = Yii::$app->user->id;

        $historyRecords = History::find()->where(['id_user' => $userId])->all();

        return $this->render('index', [
            'historyRecords' => $historyRecords,
        ]);
    }
}
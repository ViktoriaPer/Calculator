<?php

namespace app\controllers;

use Yii;
use app\models\SignupForm;
use yii\web\Controller;

class SignupController extends Controller
{
    public function actionIndex()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались.');
            return $this->goHome();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SignupForm;

class SignupController extends Controller
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

        $model = new SignupForm();

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
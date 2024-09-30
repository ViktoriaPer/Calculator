<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SignupForm;

class SignupController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
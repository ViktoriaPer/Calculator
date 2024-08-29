<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ErrorAction;
use app\config\Lists;


class CalculatorController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'blanc';

        $lists = Lists::getLists();

        return $this->render('index', 
        [
            'lists' => $lists,
        ]);
    }





}

<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\{
    CalculationForm,
    CalculationRepository
};
use app\components\calculator\CalculationResultsService;

class CalculatorController extends Controller
{
    public function actionIndex(): string
    {
        $model = new CalculationForm();

        $repository = new CalculationRepository(
            \Yii::$app->params['lists'],
            \Yii::$app->params['prices'],
        );

        $showCalculation = false;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            (new CalculationResultsService($repository))->handle($model);
            if ($repository->isPriceExists($model->month, (int) $model->tonnage, $model->type) === true) {

                $showCalculation = true;

            }

            if ($repository->isPriceExists($model->month, (int) $model->tonnage, $model->type) === false) {

                \Yii::$app->session->setFlash('error', 'Стоимость для указанных параметров отсутствует');

                \Yii::$app->response->statusCode = 404;
            }
        }

        return $this->render('index', [
            'repository' => $repository,
            'model' => $model,
            'showCalculation' => $showCalculation,
        ]);
    }
}
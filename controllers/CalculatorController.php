<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\{
    CalculationForm,
    MonthsRepository,
    TonnagesRepository,
    TypesRepository,
    PricesRepository,
};
use app\components\calculator\CalculationResultsService;

class CalculatorController extends Controller
{
    public function actionIndex(): string
    {
        $model = new CalculationForm();


        $monthsRepository=new MonthsRepository();
        $tonnagesRepository=new TonnagesRepository();
        $typesRepository=new TypesRepository();
        $repository=new PricesRepository();

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
            'monthsRepository' => $monthsRepository,
            'tonnagesRepository' => $tonnagesRepository,
            'typesRepository' => $typesRepository,
            'repository' => $repository,
            'model' => $model,
            'showCalculation' => $showCalculation,
        ]);
    }
}
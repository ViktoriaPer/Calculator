<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\{
    CalculationForm,
    MonthsRepository,
    TonnagesRepository,
    TypesRepository,
    PricesRepository,
    History,
};
use app\components\calculator\CalculationResultsService;

class CalculatorController extends Controller
{
    public function actionIndex(): string
{
    $model = new CalculationForm();

    $monthsRepository = new MonthsRepository();
    $tonnagesRepository = new TonnagesRepository();
    $typesRepository = new TypesRepository();
    $repository = new PricesRepository();

    $showCalculation = false;

    if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
        // Обработка результатов калькуляции
        (new CalculationResultsService($repository))->handle($model);

        if ($repository->isPriceExists($model->month, (int)$model->tonnage, $model->type)) {
            $showCalculation = true;

            // Сохраняем калькуляцию только если пользователь не гость
            if (!Yii::$app->user->isGuest) {
                $history = new History();
                $history->id_user = Yii::$app->user->id; // Идентификатор текущего пользователя
                $history->date = date('Y-m-d');
                $history->time = date('H:i:s');
                $history->months = $model->month;
                $history->tonnage = (int)$model->tonnage;
                $history->raw_type = $model->type;
                $history->price = $repository->getPrice($model->month, (int)$model->tonnage, $model->type);

                // Пытаемся сохранить запись в истории
                if ($history->save()) {
                    
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения в историю.');
                }
            }
        } else {
            Yii::$app->session->setFlash('error', 'Стоимость для указанных параметров отсутствует');
            Yii::$app->response->statusCode = 404;
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
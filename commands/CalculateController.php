<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use app\components\calculator\queue\ResultRenderer;
//добавила чтобы проверить, пофиксит ли ошибку
use app\components\calculator\CalculationResultsService;
use app\controllers\CalculatorController;
use app\models\{
    CalculationForm,
    CalculationRepository
};


class CalculateController extends Controller
{
    //такой тип данных, потому что иначе он выдает ошибку, что задан null 
    public ?string $month = null;
    public ?string $type = null;
    public ?int $tonnage = null;

    //задала опции, чтобы они были доступны из коммандной строки
    public function options($actionID): array
    {
        return ['month', 'type', 'tonnage'];
    }

    

    //actionIndex - работает при запуске из консоли
    public function actionIndex(): void
    {
        //Создала модель типа CalculationForm
        $model = new CalculationForm();
        
        //Присвоила значения из командной строки в свойства самой модели
        $model->month = $this->month;
        $model->tonnage = $this->tonnage;
        $model->type = $this->type;
    
        //Проверка, верно ли введены данные
        if (!$model->validate()) {
            foreach ($model->getErrors() as $errors) {
                foreach ($errors as $error) {
                    $this->stdout($error . PHP_EOL, Console::FG_RED);
                }
            }
            exit(ExitCode::UNSPECIFIED_ERROR);
        }
    
        //Создание репозитория, передача в него данных
        $repository = new CalculationRepository(
            \Yii::$app->params['lists'],
            \Yii::$app->params['prices'],
        );
        //отправить данные на сервис и обработать их
        (new CalculationResultsService($repository))->handle($model);

        //исходный код, взятый из BackgroundTaskController.php
        $basePath = \Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . 'queue';

        $renderer = new ResultRenderer($this);

        if (is_dir($basePath) === false) {

            $this->stdout('Хранилище задач не определено' . PHP_EOL, Console::FG_RED);

            exit(ExitCode::UNSPECIFIED_ERROR);
        }

        $jobs = scandir($basePath);

        array_splice($jobs, 0, 2);

        foreach ($jobs as $job) {
            $path = $basePath . DIRECTORY_SEPARATOR . $job;

            $state = json_decode(file_get_contents($path), true);

            $renderer->render($state);

            unlink($path);
        }
    }
}
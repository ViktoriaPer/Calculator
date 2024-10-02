<?php

/** @var \app\models\CalculationForm $model */
/** @var \app\models\CalculationRepository $repository */
/** @var bool $showCalculation */
$this->title = 'Калькулятор';
use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<style>
    td.with-border {
        border: 2px solid green;
    }
</style>

<div class="text-center mb-4 mt-3">
    <h1>Калькулятор стоимости доставки сырья</h1>
</div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-md-6 border rounded-3 p-4 shadow">

        <?php
            $form = ActiveForm::begin([
                'id' => 'calculator-form',
            ]);
        ?>

        <div class="mb-3">
            <?= $form->field($model, 'month')
                ->label('Месяц')
                ->dropDownList(array_map(function ($item) {
                    return mb_convert_case($item, MB_CASE_TITLE, 'UTF-8');
                },  array_combine($monthsRepository->getMonths(), $monthsRepository->getMonths())), [
                    'prompt' => 'Выберите значение',
                ]);
            ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'tonnage')
                ->label('Тоннаж')
                ->dropDownList(array_combine($tonnagesRepository->getTonnages(), $tonnagesRepository->getTonnages()), [
                    'prompt' => 'Выберите значение',
                ])
            ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'type')
                ->label('Тип сырья')
                ->dropDownList(array_map(function ($item) {
                    return mb_convert_case($item, MB_CASE_TITLE, 'UTF-8');
                }, array_combine($typesRepository->getTypes(), $typesRepository->getTypes())), [
                    'prompt' => 'Выберите значение',
                ])
            ?>
        </div>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Сброс', '/calculator', ['class' => 'btn btn-danger', 'type' => 'button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php if (\Yii::$app->session->hasFlash('error') === true): ?>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <?= \Yii::$app->session->getFlash('error') ?>
            </div>
        </div>
    </div>
<?php endif?>

<?php if ($showCalculation === true): ?>

    <div id="result" class="mb-4">
    <div class="row justify-content-center mt-5">
        <div class="col-md-3 me-3">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white" style="font-weight: bold; font-size: 17px;">
                    Введенные данные:
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong> Месяц: </strong>
                        <?= mb_convert_case($model->month, MB_CASE_TITLE, 'UTF-8'); ?>
                    </li>
                    <li class="list-group-item">
                        <strong> Тоннаж: </strong>
                        <?= mb_convert_case($model->tonnage, MB_CASE_TITLE, 'UTF-8') ?>
                    </li>
                    <li class="list-group-item">
                        <strong> Тип сырья: </strong>
                        <?= mb_convert_case($model->type, MB_CASE_TITLE, 'UTF-8') ?>
                    </li>
                    <li class="list-group-item">
                        <strong> Итог, руб.: </strong>
                        <?= $repository->getPrice($model->month, (int) $model->tonnage, $model->type) ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 table-responsive border rounded-1 shadow-lg p-0" style="margin-bottom: 10%;">
            <table class="table table-hover table-striped text-center mb-0">
                <thead>
                    <tr>
                        <th>Т/M</th>
                        <?php foreach ($tonnagesRepository->getTonnages() as $tonnage): ?>
                            <th><?= $tonnage ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $months = $monthsRepository->getMonths(); 
                    $tonnages = $tonnagesRepository->getTonnages();

                    // Формируем таблицу
                    foreach ($months as $month): ?>
                        <tr>
                            <td><?= mb_convert_case($month, MB_CASE_TITLE, 'UTF-8') ?></td>
                            <?php foreach ($tonnages as $tonnage): ?>
                                <td
                                    <?php

                                    if ($model->month === $month && (int)$model->tonnage === (int)$tonnage) {
                                        echo 'class="with-border"';
                                    }
                                    ?>>
                                    <?php
                                    if ($repository->isPriceExists($month, $tonnage, $model->type)) {
                                        echo $repository->getPrice($month, $tonnage, $model->type);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>

<?php endif ?>

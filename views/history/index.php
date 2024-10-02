<?php

$this->title = 'История рассчетов';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="text-center mb-4 mt-3">
    <h1>История рассчетов</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 border rounded-3 p-4 shadow" style="margin-bottom: 10%;">
        <?php $form = ActiveForm::begin(['id' => 'history-form']); ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Месяц</th>
                    <th>Тоннаж</th>
                    <th>Тип сырья</th>
                    <th>Цена</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historyRecords)): ?>
                    <?php foreach ($historyRecords as $record): ?>
                        <tr>
                            <td><?= Html::encode($record->date) ?></td>
                            <td><?= Html::encode($record->time) ?></td>
                            <td><?= Html::encode($record->months) ?></td>
                            <td><?= Html::encode($record->tonnage) ?></td>
                            <td><?= Html::encode($record->raw_type) ?></td>
                            <td><?= Html::encode($record->price) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Нет записей в истории расчетов.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        </div>
    </div>
<?php endif; ?>

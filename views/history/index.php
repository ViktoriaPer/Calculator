<?php

$this->title = 'История рассчетов';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="text-center mb-4 mt-3">
    <h1>История рассчетов</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 border rounded-3 p-4 shadow">
        <?php $form = ActiveForm::begin(['id' => 'history-form']); ?>

        <p>В данный момент страница находится в разработке! Ожидайте...</p>

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

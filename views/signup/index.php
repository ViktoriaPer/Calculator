<?php

$this->title = 'Вход';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<style>
    td.with-border {
        border: 2px solid green;
    }
</style>

<div class="text-center mb-4 mt-3">
    <h1>Войти</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 border rounded-3 p-4 shadow">

        <?php
            $form = ActiveForm::begin([
                'id' => 'calculator-form',
            ]);
        ?>

        

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

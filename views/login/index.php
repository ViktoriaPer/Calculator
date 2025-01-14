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
    <div class="col-md-6 border rounded-3 p-4 shadow" style="margin-bottom: 10%;">

        <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
            ]);
        ?>

        <div class="mb-3">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Логин') ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
        </div>

        <div class="form-group mb-3">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        </div>

        <div class="mb-3">
            Нет аккаунта? <?= Html::a('Зарегистрируйтесь', ['/signup']) ?> в системе 
        </div>
        <div class="row justify-content-center mt-4">

    </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

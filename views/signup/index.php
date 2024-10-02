<?php

$this->title = 'Регистрация';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="text-center mb-4 mt-3">
    <h1>Регистрация</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 border rounded-3 p-4 shadow" style="margin-bottom: 10%;">
        <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

        <div class="mb-3">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'email')->textInput()->label('E-mail') ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
        </div>

        <div class="mb-3">
            <?= $form->field($model, 'password_repeat')->passwordInput()->label('Повторите пароль') ?>
        </div>

        <div class="form-group mb-3">
            <?= Html::submitButton('Создать аккаунт', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
        </div>

        <div class="mb-3">
            Уже зарегистрированы? <?= Html::a('Войдите', ['/login']) ?> в аккаунт
        </div>

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

<?php

$this->title = 'Профиль';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="text-center mb-4 mt-3">
    <h1>Профиль</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 border rounded-3 p-4 shadow">
        <?php $form = ActiveForm::begin(['id' => 'account-form']); ?>

        <div class="profile-index">
            <p>
                <strong>Имя:</strong> <?= Html::encode($username) ?><br>
                <strong>Email:</strong> <?= Html::encode($email) ?><br>
                <strong>Роль:</strong> <?= Html::encode($role) ?><br>
            </p>

            <p>
                <?= Html::a('История расчетов', ['history/index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Редактировать аккаунт', ['#'], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('Удалить аккаунт', ['#'], ['class' => 'btn btn-danger']) ?>
            </p>
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

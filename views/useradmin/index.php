<?php

$this->title = 'Управление учетными записями';

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
?>

<div class="text-center mb-4 mt-3">
    <h1>Управление учетными записями</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-6 border rounded-3 p-4 shadow">
        <?php $form = ActiveForm::begin(['id' => 'useradmin-form']); ?>



<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'email',
            'role',
            // Добавьте другие поля пользователя, если необходимо
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('Редактировать', $url, [
                            'class' => 'btn btn-primary',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Удалить', $url, [
                            'class' => 'btn btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
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

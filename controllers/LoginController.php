<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;

class LoginController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }




    public function actionIndex()
    {
        $model = new LoginForm();

        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Здравствуйте, ' . Yii::$app->user->identity->username . ', вы авторизовались в системе расчета стоимости доставки. Теперь все ваши расчеты будут сохранены для последующего просмотра в <a href="/history">журнале расчетов</a>.');
            return $this->redirect(['/calculator']);
        }
    
        return $this->render('index', [
            'model' => $model, // Возвращаем модель для вывода ошибок
        ]);
    }
    

}
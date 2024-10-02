<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;


        $auth->removeAll(); // Удалить все роли и разрешения чтобы можно было короче обновлять

        // Создаем роли
        $guest = $auth->createRole('guest');
        $user = $auth->createRole('user');
        $admin = $auth->createRole('admin');

        // Добавляем роли в хранилище
        $auth->add($guest);
        $auth->add($user);
        $auth->add($admin);

        $viewHistory = $auth->createPermission('viewHistory');
        $viewHistory->description = 'Просмотр истории расчетов';
        $auth->add($viewHistory);

        $auth->addChild($user, $viewHistory); 
        $auth->addChild($admin, $viewHistory); 

        echo "Roles and permissions created.\n";
    }
}
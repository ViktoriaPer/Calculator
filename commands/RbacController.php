<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Удаляем существующие роли, если они есть
        $auth->removeAll(); // Удалить все роли и разрешения

        // Создаем роли
        $guest = $auth->createRole('guest');
        $user = $auth->createRole('user');
        $admin = $auth->createRole('admin');

        // Добавляем роли в хранилище
        $auth->add($guest);
        $auth->add($user);
        $auth->add($admin);

        // Создаем разрешение
        $viewHistory = $auth->createPermission('viewHistory');
        $viewHistory->description = 'Просмотр истории расчетов';
        $auth->add($viewHistory);

        // Назначаем разрешения ролям
        $auth->addChild($user, $viewHistory); // пользователи user могут видеть историю
        $auth->addChild($admin, $viewHistory); // администраторы admin могут видеть историю

        echo "Roles and permissions created.\n";
    }
}
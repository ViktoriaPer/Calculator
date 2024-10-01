<?php

   namespace app\commands;

   use Yii;
   use yii\console\Controller;

   class RbacController extends Controller
   {
       public function actionInit()
       {
           $auth = Yii::$app->authManager;

           // Создаем роли
           $guest = $auth->createRole('guest');
           $user = $auth->createRole('user');
           $admin = $auth->createRole('admin');

           // Добавляем роли в хранилище
           $auth->add($guest);
           $auth->add($user);
           $auth->add($admin);

           echo "Roles created.\n";
       }
   }
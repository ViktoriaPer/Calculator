<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\models\User; 

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>

</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>

        <?php
            NavBar::begin([
                'brandLabel' => \Yii::$app->name,
                'brandUrl'   => \Yii::$app->homeUrl,
                'options'    => [
                    'class' => 'navbar-inverse navbar-fixed-top navbar-light bg-warning',
                ],
            ]);

            $username = Yii::$app->user->isGuest ? 'Гость' : Yii::$app->user->identity->username;
            $user = User::findOne(Yii::$app->user->id); 

            $items = [

                [
                    'label' => 'Вы вошли как ' . $username,
                    'options' => ['class' => 'nav-item disabled'], 
                    'linkOptions' => ['class' => 'nav-link disabled'], 
                ],
            
            ];
            

            if (!Yii::$app->user->isGuest) {
                $items[] = [
                    'label' => 'Профиль',
                    'url' => ['/account'], 
                ];
            }
                
                $items[] = [
                    'label' => 'Рассчитать цену',
                    'url' => ['/calculator'],  
                ];

            if (!Yii::$app->user->isGuest) {    
                $items[] = [
                    'label' => 'История расчетов',
                    'url' => ['/history'],
                ];
            }

            // Добавляем пункт управления учетными записями только для пользователей с ролью admin
            if ($user && $user->getRole() === 'admin') {
                $items[] = [
                    'label' => 'Пользователи',
                    'url' => ['/useradmin'], 
                ];
            }

            // Добавляем элемент для Входа/Выхода
            $items[] = [
                'label' => Yii::$app->user->isGuest ? 'Вход' : 'Выход',
                'url' => Yii::$app->user->isGuest ? ['/login'] : ['/logout'],
                'linkOptions' => Yii::$app->user->isGuest ? [] : ['data-method' => 'post'],
            ];

            echo Nav::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'navbar-nav ms-auto'],
                'items' => $items,
            ]);

            NavBar::end();
        ?>  
    </header>

    <main id="main" class="flex-shrink-0 mt-4" role="main">
        <div class="container">
            <?= $content ?>
        </div>
    </main>



    <footer class="navbar fixed-bottom navbar-light bg-light">
        <div class="container">
            <span class="navbar-text">
              &copy; Практикум "ЭФКО Цифровые решения" <?= date('Y') ?>
            </span>
        </div>
    </footer>

    <?php $this->endBody() ?>
                

</body>

</html>
<?php $this->endPage() ?>
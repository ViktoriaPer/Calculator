<?php

/** @var yii\web\View $this */

$this->title = 'Калькулятор';

use app\assets\greeting\{AnimateAsset, GreetingAsset};

AnimateAsset::register($this);
GreetingAsset::register($this);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

const PROJECT_ROOT = '../';
include_once PROJECT_ROOT.'vendor/autoload.php';
use app\bootstrap\dropdown\{
  Label,
  Select,
};

include_once PROJECT_ROOT.'controllers/utils.php';
$lists = require_once PROJECT_ROOT.'models/lists.php';
$prices = require_once PROJECT_ROOT.'models/prices.php';

?>

<div class="wrapper">
    <header class="w-full absolute my-8 left-0 top-0">
        <div class="mx-auto container">
            <div class="flex items-end justify-end w-full">
                <div class="text-gray-700 font-normal leading-none text-sm" id="time">00:00</div>
            </div>
        </div>
    </header>


    <main id="main" class="flex-shrink-0" role="main">
        <div class="container" id="main-block">
            <div class="text-center mb-4 mt-3">
                <h1>Калькулятор стоимости доставки сырья</h1>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 border rounded-3 p-4 shadow">
                    <form id="calculate_form" action="/" method="post">
                       
                    <div class="mb-3 required">
                        <?=
                            new Label(
                                'month',
                                'Месяц',
                            )
                        ?>
                        <?=
                            new Select(
                                'month',
                                $lists['months'],
                                'Выберите параметр',
                                $_POST['month'] ?? null,
                            )
                        ?>
                    </div>
                        
                    <div class="mb-3 required">
                        <?=
                            new Label(
                                'tonnage',
                                'Тоннаж',
                            )
                        ?>
                        <?=
                            new Select(
                                'tonnage',
                                $lists['tonnages'],
                                'Выберите параметр',
                                $_POST['tonnage'] ?? null,
                            )
                        ?>
                    </div>
                    
                    
                    
                    <div class="mb-3 required">
                        <?=
                            new Label(
                                'raw-type',
                                'Тип сырья',
                            )
                        ?>
                        <?=
                            new Select(
                                'raw-type',
                                $lists['raw_types'],
                                'Выберите параметр',
                                $_POST['raw-type'] ?? null,
                            )
                        ?>
                    </div>

                        <button type="submit" id="calculate_button" class="btn btn-success">Рассчитать</button>
                        <a href="/" type="button" class="btn btn-danger">Сброс</a>
                    </form>
                </div>
            </div>
            

            <?php
                            if ( (empty($_POST['month'])) or (empty($_POST['tonnage'])) or (empty($_POST['raw-type'])) )
                                {
                                    die();
                                }
                            ?> 

            <?php if (empty($_POST) === false): ?>
            
                            

            <div id="result" class="mb-4">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-3 me-3">
                        <div class="card shadow-lg">
                            <div class="card-header bg-success text-white" style="font-weight: bold; font-size: 17px;">
                                Введите данные:  
                            </div>
                         
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Месяц: </strong> <?=  mb_convert_case($_POST['month'], MB_CASE_TITLE, 'UTF-8')  ?>
                            </li>

                            <li class="list-group-item">
                                <strong>Тоннаж: </strong> <?= mb_convert_case($_POST['tonnage'], MB_CASE_TITLE, 'UTF-8') ?>
                            </li>

                            <li class="list-group-item">
                                <strong>Тип сырья: </strong>  <?= mb_convert_case($_POST['raw-type'], MB_CASE_TITLE, 'UTF-8') ?>
                            </li>

                            <li class="list-group-item">
                                <strong>Итог, руб.: </strong> 

                                <?= findPrice($_POST['month'], (int)$_POST['tonnage'], $_POST['raw-type'], $prices); ?>
                                
                            </li>
                        </ul>    
                        </div>
                    </div>

                    <div class="col-md-6 table-responsive border rounded-1 shadow-lg p-0">
                        <table class="table table-hower table-striped text-center mb-0">
                            <thead>

                                <tr>
                                    <th>Т/М</th>
                                    <?php

                                    foreach(getPriceTonnages($_POST['raw-type'], $prices) as $tonnage ): ?>

                                    <th><?= $tonnage ?> </th>
                                    <?php endforeach ?>

                                    
                                </tr>

                            </thead>


                            <tbody>
                                <tr>

                                        
                                    <?php

                                    foreach(getPriceMonthes($_POST['raw-type'], $prices) as $month): ?>
                                    <tr>
                                        <td>
                                            <?= mb_convert_case($month, MB_CASE_TITLE, 'UTF-8') ?>
                                    </td>

                                    <?php 
                                        foreach(getPriceByRawTypeAndMonth($_POST['raw-type'], $month, $prices) as $tonnage=>$price): ?>

                                        <td class="<?= getStyleOnCondition($_POST['month'],(int)$_POST['tonnage'],$month, (int)$tonnage) ?> "> 
                                            <?= $price?>
                                        </td>
                                    <?php endforeach ?>
                                        </tr>
                                        <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif ?>  
        </div>
        
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">
                    &copy; ЭФКО 2024
                </div>
            </div>
        </div>
    </footer>
</div>
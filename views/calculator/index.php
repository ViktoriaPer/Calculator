<?php
namespace app\controllers;


/** @var yii\web\View $this */

use app\assets\greeting\{AnimateAsset, GreetingAsset};
use yii\helpers\Html;


$this->title = 'Калькулятор';




AnimateAsset::register($this);
GreetingAsset::register($this);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);









?>

<div class="wrapper">
    <header class="w-full absolute my-8 left-0 top-0">
        <div class="mx-auto container">
            <div class="flex items-end justify-end w-full">
                <div class="text-gray-700 font-normal leading-none text-sm" id="time">00:00</div>
            </div>
        </div>
    </header>


    <main>

    <!--//тут код -->
    <?php 
    
    echo Html::dropDownList('month', null, $lists['months'], 
    [
    'prompt' => 'Выберите месяц',
    'class' => 'form-control',
    ]);

    echo Html::dropDownList('tonnage', null, $lists['tonnages'], 
    [
    'prompt' => 'Выберите тоннаж',
    'class' => 'form-control',
    ]);

    echo Html::dropDownList('raw-type', null, $lists['raw_types'], 
    [
    'prompt' => 'Выберите тип сырья',
    'class' => 'form-control',
    ]);



    ?>

    

    </main>

</div>
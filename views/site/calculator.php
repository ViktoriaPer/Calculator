<?php

/** @var yii\web\View $this */

$this->title = 'Калькулятор';

use app\assets\greeting\{AnimateAsset, GreetingAsset};

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
    </main>

</div>
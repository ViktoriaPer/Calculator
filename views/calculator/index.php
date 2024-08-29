<?php
namespace app\controllers;


/** @var yii\web\View $this */

use app\assets\greeting\{AnimateAsset, GreetingAsset};
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\controllers\Lists;

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
    
    

    <div class="container" style="display: flex; justify-content: center; align-items: center; height: 85vh;">



    <div class="form-container" style="border: 1px solid gray; padding: 40px; border-radius: 5px; width: 600px;">
<!--А точно сюда?? -->    
    <form id="calculate_form" action="/" method="post">


        <h2 style="text-align: center; font-size: 2em; font-weight: bold;">Введите данные</h2>
    <br>
    <?php 
    $form = ActiveForm::begin(); 
    echo Html::dropDownList('month', null, $lists['months'], 
    [
    'prompt' => 'Выберите месяц',
    'class' => 'form-control',
    ]);
    echo '<br>';
    echo Html::dropDownList('tonnage', null, $lists['tonnages'], 
    [
    'prompt' => 'Выберите тоннаж',
    'class' => 'form-control',
    ]);
    echo '<br>';
    echo Html::dropDownList('raw-type', null, $lists['raw_types'], 
    [
    'prompt' => 'Выберите тип сырья',
    'class' => 'form-control',
    ]);
    ?>

    <br>    

    <div class="form-group" style="display: flex; justify-content: start;">
            <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-success']) ?>
            <?= Html::resetButton('Сброс', ['class' => 'btn btn-danger']) ?>
    </div>

  
    <br>

<!-- Здесь место для вывода результата-->
<div class="col-md-3 me-3">
<div class="card shadow-lg">
                        <div class="card-header bg-success text-white" style="font-weight: bold; font-size: 17px;">
                                Введите данные:  
                        </div>
                         
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Месяц: </strong> <!--  mb_convert_case($_POST['month'], MB_CASE_TITLE, 'UTF-8')  -->
                            </li>

                            <li class="list-group-item">
                                <strong>Тоннаж: </strong> <!-- mb_convert_case($_POST['tonnage'], MB_CASE_TITLE, 'UTF-8') -->
                            </li>

                            <li class="list-group-item">
                                <strong>Тип сырья: </strong>  <!-- mb_convert_case($_POST['raw-type'], MB_CASE_TITLE, 'UTF-8') -->
                            </li>

                            <li class="list-group-item">
                                <strong>Итог, руб.: </strong> 

                                <!--  findPrice($_POST['month'], (int)$_POST['tonnage'], $_POST['raw-type'], $prices); -->
                                
                            </li>
                        </ul>    
                        </div>



<!-- код от таблицы -->



    <?php ActiveForm::end(); ?>


    </div>


</div>
</div>
</main>

</div>
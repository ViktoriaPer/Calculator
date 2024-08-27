<?php

/*? - это строка */
function getSelectedAttributeOnInputCondition (array $input, string $inputName, mixed $condition, bool $asInt=false):?string
{
    if (isset($input[$inputName])===false)
    {
        return null;
    }

    $condition=$asInt===true ?(int)$condition : $condition;
    if ($input[$inputName]!==$condition)
    {
        return null;
    }
    return 'selected';

}


function getPriceTonnages(string $rawTypes, array $prices):array
{
    if (isset($prices[$rawTypes])===true)

    {
        $firstMonth=array_key_first($prices[$rawTypes]);
        return array_keys($prices[$rawTypes][$firstMonth]);
        
    }
    throw new \LogicException('Стоимость не найдена');
}

function getPriceMonthes(string $rawTypes, array $prices):array
{
    if (isset($prices[$rawTypes])===true)
    {
        return array_keys($prices[$rawTypes]);
    }
    throw new \LogicException('Не найден месяц');
}

function getPriceByRawTypeAndMonth(string $rawTypes, string $month, array $prices):array
{
    if (isset($prices[$rawTypes][$month])===true) 
    {
        return $prices[$rawTypes][$month];
    }
    throw new \LogicException('Не найдена стоимость для типа сырья');
}

function getStyleOnCondition(string $month, int $tonnage, string $conditionMonth, int $conditionTonnage): ?string
{
    if ($month!==$conditionMonth)
    {
        return null;
    }

    if ($tonnage!==$conditionTonnage)
    {
        return null;
    }
    return 'with-border';

}

function findPrice(string $month, int $tonnage, string $rawTypes, array $prices):int
{

    if (isset($prices[$rawTypes][$month][$tonnage])===true)
    {
        return $prices[$rawTypes][$month][$tonnage];
    }
    throw new \LogicException('Не найдена стоимость');
}
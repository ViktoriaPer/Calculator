<?php


namespace app\models;

use app\models\Month; //модель
class MonthsRepository
{

    public function getMonths(): array
    {
        $months=Month::find()->all();
        $result = [];
        foreach ($months as $month) {
            $result[] = $month->name; 
        }

        return $result;
    }

    public function exist(string $name): bool
    {
        $query = $this->months->select(new Expression('COUNT(name) as cnt'))
            ->from('months')
            ->where(['name' => $name]);

        return (bool) $query->one()['cnt'];
    }

    public function create(string $name): void
    {
        $this->months->createCommand()->insert('months', [
            'name' => $name,
        ])
        ->execute();
    }

    public function delete(string $name): void
    {
        $this->months->createCommand()->delete('months', [
            'name' => $name,
        ])
        ->execute();
    }
}
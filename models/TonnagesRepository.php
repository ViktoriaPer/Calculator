<?php


namespace app\models;

use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\models\Tonnage; 


class TonnagesRepository
{
    public function getTonnages(): array
    {
        $tonnages=Tonnage::find()->all();
        $result = [];
        foreach ($tonnages as $tonnage) {
            $result[] = $tonnage->value; 
        }

        return $result;
    }

    public function exist(string $value): bool
    {
        $query = $this->readConn->select(new Expression('COUNT(value) as cnt'))
            ->from('tonnages')
            ->where(['value' => $value]);

        return (bool) $query->one()['cnt'];
    }

    public function create(string $value): void
    {
        $this->writeConn->createCommand()->insert('tonnages', [
            'value' => $value,
        ])
        ->execute();
    }

    public function delete(string $value): void
    {
        $this->writeConn->createCommand()->delete('tonnages', [
            'value' => $value,
        ])
        ->execute();
    }
}
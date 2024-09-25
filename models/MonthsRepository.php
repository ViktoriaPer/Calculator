<?php


namespace app\components\months;

use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class MonthsRepository
{
    private Connection $writeConn;

    public function __construct(private readonly Query $readConn)
    {
        $this->writeConn = \Yii::$app->db;
    }

    public function getMonthsNames(): array
    {
        $query = $this->readConn->select(['name'])
            ->from('months');

        return ArrayHelper::getColumn($query->all(), 'name');
    }

    public function exist(string $name): bool
    {
        $query = $this->readConn->select(new Expression('COUNT(name) as cnt'))
            ->from('months')
            ->where(['name' => $name]);

        return (bool) $query->one()['cnt'];
    }

    public function create(string $name): void
    {
        $this->writeConn->createCommand()->insert('months', [
            'name' => $name,
        ])
        ->execute();
    }

    public function delete(string $name): void
    {
        $this->writeConn->createCommand()->delete('months', [
            'name' => $name,
        ])
        ->execute();
    }
}
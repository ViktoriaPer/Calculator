<?php


namespace app\components\tonnages;

use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class TonnagesRepository
{
    private Connection $writeConn;

    public function __construct(private readonly Query $readConn)
    {
        $this->writeConn = \Yii::$app->db;
    }

    public function getTonnagesValues(): array
    {
        $query = $this->readConn->select(['value'])
            ->from('tonnages');

        return ArrayHelper::getColumn($query->all(), 'value');
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
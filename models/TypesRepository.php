<?php


namespace app\models;

use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\models\Type;
class TypesRepository
{
    
    public function getTypes(): array
    {
        $types=Type::find()->all();
        $result = [];
        foreach ($types as $type) {
            $result[] = $type->name; 
        }

        return $result;
    }

    public function exist(string $name): bool
    {
        $query = $this->readConn->select(new Expression('COUNT(name) as cnt'))
            ->from('raw_types')
            ->where(['name' => $name]);

        return (bool) $query->one()['cnt'];
    }

    public function create(string $name): void
    {
        $this->writeConn->createCommand()->insert('raw_types', [
            'name' => $name,
        ])
        ->execute();
    }

    public function delete(string $name): void
    {
        $this->writeConn->createCommand()->delete('raw_types', [
            'name' => $name,
        ])
        ->execute();
    }
}
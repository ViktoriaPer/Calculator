<?php
namespace app\components\PricesRepository;

use yii\db\Connection;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\models\{
    CalculationForm,
    MonthsRepository,
    TonnagesRepository,
    TypesRepository,
};


class PricesRepository
{
    private Connection $writeConn;

    public function __construct(private readonly Query $readConn)
    {
        $this->writeConn = \Yii::$app->db;
    }

    public function getAll(): array
    {
        return $this->readConn->select(['*'])->from('prices')->all();
    }

  /*  public function exists(int $id): bool ВОТ СЮДА ЗАХРЕНАЧИТЬ ВСЕ ИЗ АПИ
    {
        return (bool)$this->readConn->from('prices')->where(['id' => $id])->count();
    }

    public function create(array $data): void
    {
        $this->writeConn->createCommand()->insert('prices', $data)->execute();
    }

    public function delete(int $id): void
    {
        $this->writeConn->createCommand()->delete('prices', ['id' => $id])->execute();
    }

    public function getPrice(string $month, int $tonnage, string $type): int
    {
        return $this->pricesConfig[$type][$month][$tonnage];
    }

    public function getPriceListTonnagesByRawType(string $type): array
    {
        $firstMonth = array_key_first($this->pricesConfig[$type]);

        return array_keys($this->pricesConfig[$type][$firstMonth]);
    }

    public function getPriceListMonthsByRawType(string $type): array
    {
        return array_keys($this->pricesConfig[$type]);
    }

    public function getPriceListPriceByRawTypeAndMonth(string $type, string $month): array
    {
        return $this->pricesConfig[$type][$month];
    }

    public function getPriceListByRawType(string $type): array
    {
        return $this->pricesConfig[$type];
    }

    */
}
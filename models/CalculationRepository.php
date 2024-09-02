<?php

namespace app\models;

class CalculationRepository
{
    private array $listsConfig;

    private array $pricesConfig;

    public function __construct(array $listsConfig, array $pricesConfig)
    {
        $this->listsConfig = $listsConfig;
        $this->pricesConfig = $pricesConfig;
    }

    public function getMonths(): array
    {
        return $this->listsConfig['months'];
    }

    public function getTonnages(): array
    {
        return $this->listsConfig['tonnages'];
    }

    public function getTypes(): array
    {
        return $this->listsConfig['raw_types'];
    }

    public function isPriceExists(string $month, int $tonnage, string $type): bool
    {
        return isset($this->pricesConfig[$type][$month][$tonnage]);
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
}
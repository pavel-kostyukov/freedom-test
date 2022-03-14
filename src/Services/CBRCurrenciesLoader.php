<?php

namespace App\Services;

use App\Contracts\CurrenciesLoader;
use App\Contracts\CurrencyClient;
use App\Entity\CurrencyItem;
use App\Repository\CurrencyRepository;

class CBRCurrenciesLoader implements CurrenciesLoader
{
    private CurrencyRepository $repository;
    private CurrencyClient $client;

    public function __construct(CurrencyRepository $repository, CurrencyClient $client)
    {
        $this->repository = $repository;
        $this->client = $client;
    }

    public function getCurrencyValueByDate(string $currencyCode, \DateTimeImmutable $date): CurrencyItem
    {
        if ($foundCurrency = $this->repository->findCurrencyItemByDate($currencyCode, $date)) {
            return $foundCurrency;
        }

        $currencyItem = $this->createCurrencyItem($currencyCode, $date);
        $this->saveCurrencyItem($currencyItem);
        return $currencyItem;
    }

    private function createCurrencyItem(string $currencyBase, \DateTimeImmutable $dateTo): CurrencyItem
    {
        $data = $this->client->getCurrencyDynamic(
            $dateTo->sub(new \DateInterval('P1D')),
            $dateTo,
            $currencyBase
        );

        $previousValue = (float)$data->{'ValuteData'}->{'ValuteCursDynamic'}[0]?->Vcurs;
        $currentValue = (float)$data->{'ValuteData'}->{'ValuteCursDynamic'}[1]?->Vcurs;

        if(empty($previousValue) === true) {
            throw new \InvalidArgumentException('Не найдено значение для предыдущего дня');
        }

        if(empty($currentValue) === true) {
            throw new \InvalidArgumentException('Не найдено значение для текущего дня');
        }

        return new CurrencyItem($currencyBase, $currentValue, $dateTo, $previousValue);
    }

    private function saveCurrencyItem(CurrencyItem $currencyItem)
    {
        $this->repository->add($currencyItem);
    }
}
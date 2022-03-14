<?php

namespace App\Contracts;

use App\Entity\CurrencyItem;

interface CurrenciesLoader
{
    /**
     * Получение элемента валюты по дате
     *
     * @param string $currencyCode Код валюты
     * @param \DateTimeImmutable $date Дата
     *
     * @return CurrencyItem
     */
    public function getCurrencyValueByDate(string $currencyCode, \DateTimeImmutable $date): CurrencyItem;
}
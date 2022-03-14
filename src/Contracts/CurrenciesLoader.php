<?php

namespace App\Contracts;

use App\Entity\CurrencyItem;

interface CurrenciesLoader
{
    public function getCurrencyValueByDate(string $currencyCode, \DateTimeImmutable $date): CurrencyItem;
}
<?php

namespace App\Contracts;

interface CurrencyClient
{
    public function getCurrencyDynamic(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, string $code);
}
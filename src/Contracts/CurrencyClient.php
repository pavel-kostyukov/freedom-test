<?php

namespace App\Contracts;

interface CurrencyClient
{
    /**
     * Получение информации о динамики валюты за период
     *
     * @param \DateTimeInterface $dateFrom Период от
     * @param \DateTimeInterface $dateTo Период до
     * @param string $code Код валюты
     * @throws \Exception
     */
    public function getCurrencyDynamic(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, string $code);
}
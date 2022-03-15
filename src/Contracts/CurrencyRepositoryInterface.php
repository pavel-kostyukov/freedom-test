<?php

namespace App\Contracts;

use App\Entity\CurrencyItem;

interface CurrencyRepositoryInterface
{
    /**
     * Сохранение элемента в Redis
     *
     * @param CurrencyItem $currencyItem Элемент валюты
     *
     * @return void
     */
    public function add(CurrencyItem $currencyItem);

    /**
     * Поиск элемента валюты в Redis
     *
     * @param string $code Код валюты
     * @param \DateTimeInterface $dateTime Дата
     *
     * @return CurrencyItem|null
     */
    public function findCurrencyItemByDate(string $code, \DateTimeInterface $dateTime): ?CurrencyItem;
}
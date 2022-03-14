<?php

namespace App\Repository;

use App\Entity\CurrencyItem;
use Predis\Client;

class CurrencyRepository
{
    private Client $redis;
    private string $namespace;
    private int $countDaysForSave;

    public function __construct(Client $redis, string $namespace, int $countDaysForSave)
    {
        $this->redis = $redis;
        $this->namespace = $namespace;
        $this->countDaysForSave = $countDaysForSave;
    }

    /**
     * Сохранение элемента в Redis
     *
     * @param CurrencyItem $currencyItem Элемент валюты
     *
     * @return void
     */
    public function add(CurrencyItem $currencyItem)
    {
        $key = "{$currencyItem->getDate()->format('d-m-Y')}:{$currencyItem->getCode()}";

        $this->redis->hset($this->namespace, $key, $currencyItem->toJson());
        $this->redis->expire($key, 86400 * $this->countDaysForSave);
    }

    /**
     * Поиск элемента валюты в Redis
     *
     * @param string $code Код валюты
     * @param \DateTimeInterface $dateTime Дата
     *
     * @return CurrencyItem|null
     */
    public function findCurrencyItemByDate(string $code, \DateTimeInterface $dateTime): ?CurrencyItem
    {
        $foundCurrency = $this->redis->hget($this->namespace, "{$dateTime->format('d-m-Y')}:$code");

        if(empty($foundCurrency) === true) {
            return null;
        }

        $foundCurrency = json_decode($foundCurrency, true);

        return new CurrencyItem(
            $code,
            $foundCurrency['value'],
            $dateTime,
            $foundCurrency['value_previews_day']
        );
    }
}
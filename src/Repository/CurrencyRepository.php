<?php

namespace App\Repository;

use App\Entity\CurrencyItem;
use Predis\Client;

class CurrencyRepository
{
    private Client $redis;
    private string $namespace;

    public function __construct(Client $redis, string $namespace)
    {
        $this->redis = $redis;
        $this->namespace = $namespace;
    }

    public function add(CurrencyItem $currencyItem)
    {
        $field = "{$currencyItem->getDate()->format('d-m-Y')}:{$currencyItem->getCode()}";

        $this->redis->hset($this->namespace, $field, $currencyItem->toJson());
    }

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
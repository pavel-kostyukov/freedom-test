<?php

namespace App\Services;

use App\Contracts\CurrenciesLoader;
use App\Entity\CurrencyItem;
use Predis\Client;

class CBRCurrenciesLoader implements CurrenciesLoader
{
    private string $xmlUrl;
    private \Redis $redis;

    public function __construct(string $xmlUrl, Client $redis)
    {
        dd($redis);
        $this->xmlUrl = $xmlUrl;
        $this->redis = $redis;
    }

    public function getCurrencyValueByDate(string $currencyCode, \DateTimeInterface $date): CurrencyItem
    {
        $this->loadXml();
    }

    private function loadXml()
    {
        $document = new \DOMDocument();
        $result = [];

        if($document->load($this->xmlUrl) === false) {
            throw new \LogicException('Ошибка загрузки валют');
        }

        foreach ($document->documentElement->getElementsByTagName('Valute') as $currency) {
            $code = $currency->getElementsByTagName('CharCode')->item(0)->nodeValue;
            $value = $currency->getElementsByTagName('Value')->item(0)->nodeValue;

            $result[$code] = new CurrencyItem($code, $value);
        }
    }
}
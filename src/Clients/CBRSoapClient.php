<?php

namespace App\Clients;


use App\Contracts\CurrencyClient;

class CBRSoapClient implements CurrencyClient
{
    private \SoapClient $client;

    public function __construct(string $soapUrlWsdl, bool $debugMode = false)
    {
        $this->client = new \SoapClient($soapUrlWsdl, [
                'soap_version' => SOAP_1_2,
                'trace' => $debugMode,
            ]
        );
    }

    public function getCurrencyDynamic(\DateTimeInterface $dateFrom, \DateTimeInterface $dateTo, string $code)
    {
        return new \SimpleXMLElement($this->client->__soapCall('GetCursDynamic', [
            'parameters' => [
                'FromDate' => $dateFrom->format('Y-m-d'),
                'ToDate' => $dateTo->format('Y-m-d'),
                'ValutaCode' => $code
            ]
        ])->GetCursDynamicResult->any);
    }
}
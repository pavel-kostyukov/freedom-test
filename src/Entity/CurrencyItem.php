<?php

namespace App\Entity;

class CurrencyItem
{
    private string $code;
    private float $value;
    private float $previewDayValue;

    public function __construct(string $code, float $value, float $previewDayValue)
    {
        $this->code = $code;
        $this->value = $value;
        $this->previewDayValue = $previewDayValue;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return float
     */
    public function getPreviewDayValue(): float
    {
        return $this->previewDayValue;
    }
}
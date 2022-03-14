<?php

namespace App\Entity;

class CurrencyItem implements \JsonSerializable
{
    private string $code;
    private float $value;
    private float $previewDayValue;
    private \DateTimeInterface $date;

    public function __construct(string $code, float $value, \DateTimeInterface $date, float $previewDayValue = null)
    {
        $this->code = $code;
        $this->value = $value;
        $this->previewDayValue = $previewDayValue;
        $this->date = $date;
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

    public function getValuesDiff(): float
    {
        return $this->value - $this->previewDayValue;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function jsonSerialize()
    {
        return json_encode([
            'code' => $this->getCode(),
            'value' => $this->getValue(),
            'value_previews_day' => $this->getPreviewDayValue()
        ]);
    }

    public function toJson(): string
    {
        return $this->jsonSerialize();
    }
}
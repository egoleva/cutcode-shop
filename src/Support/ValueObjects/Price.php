<?php

namespace Support\ValueObjects;


use http\Exception\InvalidArgumentException;
use Support\Traits\Makeable;
use Stringable;

class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];

    public function __construct(
        protected readonly int $value,
        protected readonly string $currency = 'RUB',
        protected readonly int $precision = 100
    )
    {
        if($value < 0)
        {
            throw new InvalidArgumentException('Price must be more than zero');
        }
        if(!isset($this->currencies[$currency]))
        {
            throw new InvalidArgumentException('Currency not allowed');
        }
    }

    public function raw(): int
    {
        return $this->value;
    }

    public function value(): int|float
    {
        return $this->value/$this->precision;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
         return number_format($this->value(), 0, ',', ' ')
             . ' ' . $this->symbol();
    }

}
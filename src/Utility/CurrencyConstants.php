<?php


namespace App\Utility;


use App\Exception\CurrencyNotManagedException;

class CurrencyConstants
{
    public const EURO = 'EUR';
    public const DOLLAR = 'USD';
    public const GBP = 'GBP';

    public const CURRENCIES_SYMBOL = [
        '€' => self::EURO,
        '$' => self::DOLLAR,
        '£' => self::GBP
    ];

    /**
     * @param string $code
     *
     * @return string
     */
    public static function getSymbol(string $code)
    {
        $values = array_flip(self::CURRENCIES_SYMBOL);

        return $values[$code];
    }
}
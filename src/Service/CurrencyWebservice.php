<?php


namespace App\Service;


use App\Utility\CurrencyConstants;

class CurrencyWebservice
{
    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return float
     *
     * @throws \Exception
     */
    public function getExchangeRate(string $currencyFrom, string $currencyTo)
    {
        //FAKE METHOD WITH FAKE OPERATIONS
        switch ($currencyTo) {
            case CurrencyConstants::EURO: return 1.2;
            case CurrencyConstants::GBP: return 1.4;
            case CurrencyConstants::DOLLAR: return 0.8;
            default:
                throw new \Exception('Currency '. $currencyTo .' is not supported'); //Generic exception by external service
        }
    }
}
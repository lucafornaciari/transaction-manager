<?php


namespace App\Service;

use App\Entity\Currency;
use App\Entity\Transaction;
use App\Exception\CurrencyNotManagedException;
use App\Exception\CurrencyWebServiceException;
use App\Utility\CurrencyConstants;

class CurrencyConverter
{
    /** @var CurrencyWebservice */
    protected $currencyWebservice;

    public function __construct(CurrencyWebservice $currencyWebservice)
    {
        $this->currencyWebservice = $currencyWebservice;
    }

    /**
     * @param Transaction $transaction
     * @param string $currencyTo
     *
     * @return Transaction
     * @throws CurrencyWebServiceException
     */
    public function convert(Transaction $transaction, string $currencyTo = CurrencyConstants::EURO)
    {
        /** @var Currency $amount */
        $amount = $transaction->getAmount();

        if ($amount->getCode() === $currencyTo) {
            //skip the conversion because the currency is correct
            return $transaction;
        }

        try {
            //We can cache the service response for 12h or 24h
            $exchangeRate = $this->currencyWebservice->getExchangeRate($amount->getCode(), $currencyTo);
        } catch (\Exception $e) {
            //Mapping external service exception in a Domain Exception
            throw new CurrencyWebServiceException($e->getMessage());
        }

        $amount->setValue($amount->getValue() * $exchangeRate);
        $amount->setCode($currencyTo);
        $amount->setSymbol(CurrencyConstants::getSymbol($currencyTo));

        $transaction->setAmount($amount);

        return $transaction;
    }
}
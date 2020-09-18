<?php


namespace App\Formatter;


use App\Entity\Currency;
use App\Entity\Transaction;
use App\Exception\CurrencyNotManagedException;
use App\Utility\CurrencyConstants;

class TransactionFormatter implements FormatterInterface
{
    /**
     * This method is used when we retrieve info from db (CSV in this case). We map the DB Entity on ours Domain Entities.
     *
     * @param array $data
     *
     * @return Transaction
     * @throws CurrencyNotManagedException
     */
    public function format(array $data)
    {
        $transaction = new Transaction();
        $transaction->setCustomer(intval($data[0]));
        $transaction->setDate($data[1]);

        $currencySymbol = mb_substr($data[2], 0, 1, 'UTF-8');
        if (empty(CurrencyConstants::CURRENCIES_SYMBOL[$currencySymbol])) {
            throw new CurrencyNotManagedException('Currency loaded is not supported');
        }

        $amount = new Currency();
        $amount->setValue(floatval(mb_substr($data[2], 1, null, 'UTF-8')));
        $amount->setSymbol($currencySymbol);
        $amount->setCode(CurrencyConstants::CURRENCIES_SYMBOL[$currencySymbol]);

        $transaction->setAmount($amount);

        return $transaction;
    }
}
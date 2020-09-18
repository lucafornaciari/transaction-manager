<?php


namespace App\Tests\Service;


use App\Entity\Currency;
use App\Entity\Transaction;
use App\Exception\CurrencyNotManagedException;
use App\Service\CurrencyConverter;
use App\Service\CurrencyWebservice;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    /** @var CurrencyConverter */
    private $currencyConverter;

    public function setUp()
    {
        $currencyWebservice = $this->createMock(CurrencyWebservice::class);
        //Mock return of getExchangeRate method currency
        $currencyWebservice->expects($this->any())->method('getExchangeRate')->willReturn(1.2);

        $this->currencyConverter = new CurrencyConverter($currencyWebservice);
    }

    /**
     * @dataProvider convertDataProvider
     *
     * @param string $symbol
     * @param string $code
     * @param float $value
     * @param string $symbolTo
     * @param string $codeTo
     *
     * @throws CurrencyNotManagedException
     */
    public function testConvert(string $symbol, string $code, float $value, string $symbolTo, string $codeTo)
    {
        $amount = new Currency();
        $amount->setSymbol($symbol);
        $amount->setCode($code);
        $amount->setValue($value);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDate('12/03/2019');
        $transaction->setCustomer(2);

        /** @var Transaction $transactionResult */
        $transactionResult = $this->currencyConverter->convert($transaction, $codeTo);
        $this->assertEquals($transactionResult->getAmount()->getSymbol(), $symbolTo);
        $this->assertEquals($transactionResult->getAmount()->getCode(), $codeTo);

        if ($code === $codeTo) {
            //if the currencies are the same, currency converte must not change nothing
            $this->assertEquals($transactionResult->getAmount()->getValue(), $value);
        } else {
            //the exchange rate changes frequently, so we can test that the value is different.
            $this->assertNotEquals($transactionResult->getAmount()->getValue(), $value);
        }

        //Customer and Date must not change
        $this->assertEquals($transactionResult->getDate(), '12/03/2019');
        $this->assertEquals($transactionResult->getCustomer(), 2);
    }

    public function convertDataProvider()
    {
        return [
            ['$', 'USD', 2, '€', 'EUR'],
            ['$', 'USD', 2, '$', 'USD'],
            ['$', 'USD', 2, '£', 'GBP']
        ];
    }


    /**
     * @throws CurrencyNotManagedException
     */
    public function testConvertWithCurrencyNotManagedException()
    {
        $this->expectException(CurrencyNotManagedException::class);

        $amount = new Currency();
        $amount->setSymbol('€');
        $amount->setCode('EUR');
        $amount->setValue(2.4);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDate('12/03/2019');
        $transaction->setCustomer(2);

        $this->currencyConverter->convert($transaction, 'BLABLA');
    }
}
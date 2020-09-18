<?php


namespace App\Tests\Formatter;


use App\Entity\Transaction;
use App\Exception\CurrencyNotManagedException;
use App\Formatter\TransactionFormatter;
use PHPUnit\Framework\TestCase;

class TransactionFormatterTest extends TestCase
{
    /** @var TransactionFormatter */
    protected $transactionFormatter;

    public function setUp()
    {
        $this->transactionFormatter = new TransactionFormatter();
    }

    /**
     * @dataProvider formatDataProvider
     *
     * @param array $data
     * @param int $expectedCustomer
     * @param string $expectedDate
     * @param float $expectedAmountValue
     * @param string $expectedAmountCode
     * @param string $expectedSymbol
     *
     * @throws CurrencyNotManagedException
     */
    public function testFormat(array $data, int $expectedCustomer, string $expectedDate, float $expectedAmountValue, string $expectedAmountCode, string $expectedSymbol)
    {
        $result = $this->transactionFormatter->format($data);

        $this->assertInstanceOf(Transaction::class, $result);
        $this->assertEquals($result->getCustomer(), $expectedCustomer);
        $this->assertEquals($result->getDate(), $expectedDate);
        $this->assertEquals($result->getAmount()->getValue(), $expectedAmountValue);
        $this->assertEquals($result->getAmount()->getCode(), $expectedAmountCode);
        $this->assertEquals($result->getAmount()->getSymbol(), $expectedSymbol);
    }

    /**
     * @return array
     */
    public function formatDataProvider()
    {
        return [
            [
                [1, '01/04/2015', '£50.00'],
                1,
                '01/04/2015',
                50,
                'GBP',
                '£'
            ],
            [
                [2, '01/05/2017', '€50.13'],
                2,
                '01/05/2017',
                50.13,
                'EUR',
                '€'
            ],
            [
                [3, '10/12/2017', '$10.5'],
                3,
                '10/12/2017',
                10.5,
                'USD',
                '$'
            ],
        ];
    }

    /**
     * @dataProvider currencyNotManagedExceptionDataProvider
     *
     * @param $data
     * @throws CurrencyNotManagedException
     */
    public function testCurrencyNotManagedException($data)
    {
        $this->expectException(CurrencyNotManagedException::class);

        $this->transactionFormatter->format($data);
    }

    /**
     * @return array
     */
    public function currencyNotManagedExceptionDataProvider()
    {
        return [
            [
                [1, '01/04/2015', '¥20.00'],
            ]
        ];
    }
}
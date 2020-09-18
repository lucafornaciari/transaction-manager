<?php


namespace App\Tests\Utility;


use App\Utility\CurrencyConstants;
use PHPUnit\Framework\TestCase;

class CurrencyConstantsTest extends TestCase
{
    public function testGetSymbol()
    {
        $result = CurrencyConstants::getSymbol('EUR');
        $this->assertEquals('€', $result);

        $result = CurrencyConstants::getSymbol('USD');
        $this->assertEquals('$', $result);

        $result = CurrencyConstants::getSymbol('GBP');
        $this->assertEquals('£', $result);

        $result = CurrencyConstants::getSymbol('FAKE_CURRENCY');
        $this->assertEquals(null, $result);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: rabib
 * Date: 7/8/2018
 * Time: 5:50 PM
 */

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Formatter;

class FormatterTest extends TestCase
{
    public function setUp()
    {
        $this->Formatter = new Formatter();
    }

    public function tearDown()
    {
        unset($this->Formatter);
    }

    /**
     * @param $input
     * @param $expected
     * @param $msg
     * @dataProvider provideCurrencyAmount
     */
    public function testCurrencyAmount($input, $expected, $msg)
    {
        $this->assertSame(
            $expected,
            $this->Formatter->currencyAmount($input),
            $msg
        );
    }

    public function provideCurrencyAmount() {
        return [
            [1, 1.00, '1 should be transformed into 1.00'],
            [1.1, 1.10, '1 should be transformed into 1.10'],
            [1.11, 1.11, '1 should stay as 1.11'],
            [1.111, 1.11, '1 should be transformed into 1.11'],
        ];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: rabib
 * Date: 7/4/2018
 * Time: 8:12 PM
 */
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
    public function setUp()
    {
        $this->Receipt = new Receipt();
    }

    public function tearDown()
    {
        unset($this->Receipt);
    }

    /**
     * @dataProvider provideSubTotal
     */
    public function testSubTotal($items, $expected){
        $coupon = null;
        $output =  $this->Receipt->subtotal($items, $coupon);
        $this->assertEquals(
            $expected,
            $output,
            "When summing the total should equal {$expected}"
        );
    }

    public function provideSubTotal(){
        return [
            [[1,2,5,8], 16],
            [[-1,2,5,8], 14],
            [[1,2,8], 11],
        ];
    }

    public function testCouponSubTotal(){
        $input = [0,2,5,8];
        $coupon = 0.20;
        $output =  $this->Receipt->subtotal($input, $coupon);
        $this->assertEquals(
            12,
            $output,
            "When summing the total should equal 12"
        );
    }

    public function testTax(){
        $inputAmount = 10.00;
        $this->Receipt->tax = 0.10;
        $output = $this->Receipt->tax($inputAmount);
        $this->assertEquals(
          1.00,
          $output,
          "The tax amount is equal to 1"
        );
    }

    public function testPostTaxTotal(){
        $items = [1,2,5,8];
        $tax = 0.20;
        $coupon = null;
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax','subtotal'])
            ->getMock();

        $Receipt->expects($this->once())
            ->method('subtotal')
            ->with($items, $coupon)
            ->will($this->returnValue(10.00));

        $Receipt->expects($this->once())
            ->method('tax')
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00));

        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
        $this->assertEquals(11.00, $result);
    }


    public function testSubTotalException(){
        $input = [0,2,5,8];
        $coupon = 1.20;
        $this->expectException('BadMethodCallException');
        $this->Receipt->subtotal($input,$coupon);
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
          $this->Receipt->currencyAmount($input),
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
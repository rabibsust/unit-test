<?php

namespace TDD;

use \BadMethodCallException;

class Receipt {
    public function __construct($formatter)
    {
        $this->Formatter = $formatter;
    }

    public function subtotal(array $items = [], $coupon){
        if ($coupon > 1.00)
        {
            throw  new BadMethodCallException('Coupon must be in between 1.00');
        }
        $sum = array_sum($items);
        if ($coupon != null){
            return $sum - ($sum*$coupon);
        }
        return $sum;
    }
    public function tax($amount){
        $result = $this->Formatter->currencyAmount($amount * $this->tax);
        return $result;
    }
    public function postTaxTotal($items, $coupon){
        $subtotal = $this->subtotal($items,$coupon);
        return $subtotal + $this->tax($subtotal,$this->tax);
    }
}
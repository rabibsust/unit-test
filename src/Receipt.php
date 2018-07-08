<?php

namespace TDD;

use \BadMethodCallException;

class Receipt {
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
        $result = $amount * $this->tax;
        return $result;
    }
    public function postTaxTotal($items, $tax, $coupon){
        $subtotal = $this->subtotal($items,$coupon);
        return $subtotal + $this->tax($subtotal,$tax);
    }
    public function currencyAmount($input){
        return round($input,2);
    }
}
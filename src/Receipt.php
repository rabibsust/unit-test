<?php

namespace TDD;

use \BadMethodCallException;

class Receipt {
    public function total(array $items = [], $coupon){
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
    public function tax($amount, $tax){
        $result = $amount * $tax;
        return $result;
    }
    public function postTaxTotal($items, $tax, $coupon){
        $subtotal = $this->total($items,$coupon);
        return $subtotal + $this->tax($subtotal,$tax);
    }
}
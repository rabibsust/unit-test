<?php

namespace TDD;

class Receipt {
    public function total(array $items = [], $coupon){
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
}
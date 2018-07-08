<?php
/**
 * Created by PhpStorm.
 * User: rabib
 * Date: 7/8/2018
 * Time: 5:53 PM
 */

namespace TDD;


class Formatter
{
    public function currencyAmount($input){
        return round($input,2);
    }
}
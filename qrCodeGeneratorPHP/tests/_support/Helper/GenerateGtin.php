<?php

namespace Helper;

class GenerateGtin extends \Codeception\Module {
    
    public function generateGtin($lenght) {
        $string = "";
        for ($i = 0; $i < $lenght - 1; $i++)
            $string = $string . mt_rand(0,9);
        $string = str_pad($string, 13, "0", STR_PAD_LEFT);
        $string = str_pad($string, 14, "0", STR_PAD_RIGHT);
        return $this->addCheckDigit($string);;
    }

    public function generateEAN128($lenght) {
        $string = "";
        for ($i = 0; $i < $lenght ; $i++)
            $string = $string . mt_rand(0,9);
        return $this->addCheckDigit($string);
    }

    public function generateEAN128Gtin($gtin) {
        $string = "";
        for ($i = 0; $i < 7; $i++)
            $string = $string . mt_rand(0,9);
        $result = $gtin . $string;
        return $this->addCheckDigit($result);
    }

    public function addCheckDigit($string) {
        $array = str_split($string);
        $sum = 0;
        for ($i = 0; $i < sizeof($array) - 1; $i++) {
            if ( (sizeof($array) + $i) % 2 == 0)
                $sum += (int)$array[$i] * 3;
            else
                $sum += (int)$array[$i];
        }
        $array[sizeof($array)-1] = (10 - ($sum % 10)) % 10;
        return implode( "", $array );
    }

}
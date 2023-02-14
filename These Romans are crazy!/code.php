<?php

const ROMAN = [1000 => "M", 900 => "CM", 500 => "D", 400 => "CD", 100 => "C", 90 => "XC", 50 => "L", 40 => "XL", 10 => "X", 9 => "IX", 5 => "V", 4 => "IV", 1 => "I"];

//Convert an integer to it's Roman-numeral representation
function convertToRoman(int $number): string {
    $convert = "";
    
    while($number > 0) {
        foreach(ROMAN as $v => $s) {
            if($v <= $number) {
                $convert .= $s;
                $number -= $v;
                continue 2; 
            }
        }
    }

    return $convert;
}

//Convert a Roman-numeral to it's integer representation
function convertToInteger(string $roman): int {
    $integer = 0;

    while(empty($roman) != true) {
        foreach(array_flip(ROMAN) as $s => $v) {
            if(strpos($roman, $s) === 0) {
                $integer += $v;
                $roman = substr($roman, strlen($s));
                continue 2; 
            }
        }
    }

    return $integer;
}

echo convertToRoman( convertToInteger( trim(fgets(STDIN)) ) + convertToInteger( trim(fgets(STDIN)) ) ) . PHP_EOL;

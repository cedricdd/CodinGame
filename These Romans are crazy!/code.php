<?php

const ROMAN = [1000 => "M", 900 => "CM", 500 => "D", 400 => "CD", 100 => "C", 90 => "XC", 50 => "L", 40 => "XL", 10 => "X", 9 => "IX", 5 => "V", 4 => "IV", 1 => "I"];

//Convert an integer to it's Roman-numeral representation
function convertToRoman(int $number): string {
    $convert = "";

    foreach(ROMAN as $v => $s) {
        while($v <= $number) {
            $convert .= $s;
            $number -= $v; 
        }
    }

    return $convert;
}

//Convert a Roman-numeral to it's integer representation
function convertToInteger(string $roman): int {
    $integer = 0;

    foreach(ROMAN as $v => $s) {
        while(strpos($roman, $s) === 0) {
            $integer += $v;
            $roman = substr($roman, strlen($s));
        }
    }

    return $integer;
}

echo convertToRoman( convertToInteger( trim(fgets(STDIN)) ) + convertToInteger( trim(fgets(STDIN)) ) ) . PHP_EOL;

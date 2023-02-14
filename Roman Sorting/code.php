<?php

const ROMAN = [1000 => "M", 900 => "CM", 500 => "D", 400 => "CD", 100 => "C", 90 => "XC", 50 => "L", 40 => "XL", 10 => "X", 9 => "IX", 5 => "V", 4 => "IV", 1 => "I"];

//Convert an integer to it's Roman-numeral representation
function convertToRoman(int $n): string {
    $convert = "";
    
    while($n > 0) {
        foreach(ROMAN as $v => $s) {
            if($v <= $n) {
                $convert .= $s;
                $n -= $v;
                continue 2; 
            }
        }
    }

    return $convert;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++)
{
    fscanf(STDIN, "%d", $x);
    $numbers[] = [$x, convertToRoman($x)];
}

//Sort in alphabetical order of the Roman-numeral representation
usort($numbers, function($a, $b) {
    return $a[1] <=> $b[1];
});

echo implode(" ", array_column($numbers, 0)) . PHP_EOL;

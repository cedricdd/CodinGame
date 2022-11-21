<?php

$isNegative = false;
$isDecimal = false;

fscanf(STDIN, "%d", $N);
foreach(explode(" ", trim(fgets(STDIN))) as $character) {
    switch($character) {
        case "-": $isNegative = true; break;
        case ".": $isDecimal = true; break;
        default: $digits[] = $character;
    }
}

//Sort digits based on if we want a positive or negative number
if($isNegative) sort($digits); 
else rsort($digits);

$number = implode("", $digits);
if($isDecimal) $number = substr_replace($number, ".", ($isNegative ? 1: -1), 0); //Add the dot
if($isNegative) $number *= -1; //Make the number negative

//Easily take care of the trailing 0
echo ($number + 0) . PHP_EOL;

<?php

function solve(array $digits, int $K, string $equation): void {

    if(count($digits) == 0) {
        if(eval("return $equation;") == $K) echo $equation . PHP_EOL;
        return;
    }

    $digit = array_pop($digits);

    solve($digits, $K, $equation . $digit); //Append the digit to the current number
    solve($digits, $K, $equation . "+" . $digit); //Create a new addition
    solve($digits, $K, $equation . "-" . $digit); //Create a new subtraction  
}

fscanf(STDIN, "%s", $S);
fscanf(STDIN, "%d", $K);

$digits = str_split(strrev($S));
$first = array_pop($digits);

solve($digits, $K, $first);

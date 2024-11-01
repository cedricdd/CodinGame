<?php

function generate(int $mask) {
    global $listIntegers;

    $previous = [];

    while($mask) {
        $bit = $mask & 1;
        $previousNext = [];

        //We can generate some values here
        if($bit == 1) {
            foreach(($previous ?: ['']) as $end) {
                $listIntegers[] = bindec('1' . $end);
                $previousNext[] = '1' . $end;
            }
        }

        foreach(($previous ?: ['']) as $end) $previousNext[] = '0' . $end;

        $previous = $previousNext;

        if(count($listIntegers) > 15) break; //We don't need more than the 15 smallest values
        else $mask >>= 1;
    } 
}

$start = microtime(1);

$listIntegers = [];
$mask = trim(fgets(STDIN));
$binary = base_convert($mask, 16, 2);
$integer = base_convert($mask, 16, 10);

generate($integer);

sort($listIntegers);

//We have 15 or less, show everything
if(count($listIntegers) <= 15) echo implode(",", $listIntegers) . PHP_EOL;
//Show the 13 first, the largest is just the input and the second largest is just the rightmost 1 replaced with a 0
else echo implode(",", array_slice($listIntegers, 0, 13)) . ",...," . bindec(substr_replace($binary, '0', strripos($binary, '1'), 1)) . "," . $integer . PHP_EOL;

error_log(microtime(1) - $start);

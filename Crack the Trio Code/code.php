<?php

//Generate all the three numbers combinaisons we need to check
function combinaisons(int $min, int $max) {
    for($i = max(1, intdiv($min, 3)); $i <= $min; ++$i) {
        for($j = $i; $j < $max; ++$j) {
            for($k = max($j, intdiv($max, 3)); $k <= $max; ++$k) {
                yield [$i, $j, $k];
            }
        }
    }
}

$start = microtime(1);

$inputs = explode(",", trim(fgets(STDIN)));

$solution = null;

foreach(combinaisons($inputs[0], $inputs[array_key_last($inputs)]) as [$a, $b, $c]) {

    //Generate all the sums we can create with our three numbers
    $sums = [];

    for ($i = 0; $i <= 3; $i++) {
        for ($j = 0; $j <= 3 - $i; $j++) {
            for ($k = 0; $k <= 3 - $i - $j; $k++) {
                if ($i + $j + $k > 0) { 
                    $sums[$i * $a + $j * $b + $k * $c] = 1;
                }
            }
        }
    }

    //Check if all the inputs can be generated with our three numbers
    foreach($inputs as $input) {
        if(!isset($sums[$input])) continue 2;
    }

    if($solution !== null) exit("many"); //We have at least 2 solutions, we don't care how many there are in total
    else $solution = $a . "," . $b . "," . $c;
}

if($solution !== null) echo $solution . PHP_EOL;
else echo "none" . PHP_EOL;

error_log(microtime(1) - $start);

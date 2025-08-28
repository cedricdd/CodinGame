<?php

fscanf(STDIN, "%d", $n);

$b = 2;
$sum = 0;

while(($p = $b * $b) <= $n) {

    while($p <= $n) {
        $sum += $b;
        $valid[$p] = true;
        $p *= $b;
    }

    ++$b;
}

echo count($valid) . " " . $sum . PHP_EOL;

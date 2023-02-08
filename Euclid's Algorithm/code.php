<?php

function Euclid(int $a, int $b): int {
    $r = $a % $b;

    echo $a . "=" . $b . "*" . intdiv($a, $b) . "+" . $r . PHP_EOL;

    return $r ? Euclid($b, $r) : $b;
}

fscanf(STDIN, "%d %d", $a, $b);

echo "GCD(" . $a . "," . $b . ")=" . Euclid($a, $b) . PHP_EOL;

<?php

fscanf(STDIN, "%d %d", $a, $b);

$result = $a * $b;
$c = "";

if($b > $a) [$a, $b] = [$b, $a];

echo $a . " * " . $b . PHP_EOL;

while($b != 0) {
    if($b % 2) {
        $c .= " + $a";
        $b -= 1;
    } else {
        $b /= 2;
        $a *= 2;
    }

    echo "= " . $a . " * " . $b . $c . PHP_EOL;
}

echo "= " . $result . PHP_EOL;

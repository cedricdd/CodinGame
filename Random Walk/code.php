<?php

fscanf(STDIN, "%d", $a);
fscanf(STDIN, "%d", $b);
fscanf(STDIN, "%d", $m);

$x = 0;
$y = 0;
$d = 0;
$step = 0;

do {
    $d = ($a * $d + $b) % $m;

    switch($d % 4) {
        case 0; --$y; break;
        case 1; ++$y; break;
        case 2; --$x; break;
        case 3; ++$x; break;
    }

    ++$step;

} while($x != 0 || $y != 0);

echo $step . PHP_EOL;

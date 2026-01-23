<?php

function wythoffMove(int $x, int $y): bool
{
    // Ensure x <= y
    if ($x > $y) [$x, $y] = [$y, $x];

    $phi = (1 + sqrt(5)) / 2;
    $k = $y - $x;
    $a = (int) floor($k * $phi);
    $b = $a + $k;

    // Losing position
    if ($x === $a && $y === $b) return false;
    else return true;
}

fscanf(STDIN, "%d %d", $n, $m);

echo (wythoffMove($n, $m) ? "FIRST" : "SECOND") . PHP_EOL;

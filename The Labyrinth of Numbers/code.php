<?php

function getFullSquaresSum(int $size, int $layer): int {
    $n = ceil($size / 2);
    $m = $n - $layer + 2;

    /**
     * The sizes of each squares starting from the center one are:
     * $n is even: 4 - 12 - 20 - 28 - 36 - ...
     * $n is odd: 1 - 8 - 16 - 24 - 32 ...
     * 
     * $n is even the sum of all squares from rank m to n is S = 4(n - m + 1)(m + n - 1)
     * $n is odd the sum of all squares from rank m to n is S = 4(n - m + 1)(m + n - 2) with m >= 2 which is always the case, the smallest one (m = 1) will never be fully added
     */
    return 4 * ($n - $m + 1) * ($m + $n - ($size & 1 ? 2 : 1));
}

fscanf(STDIN, "%d %d %d", $n, $r, $c);

$fromTop = $r;
$fromRight = $n - $c + 1;
$fromBottom = $n - $r + 1;
$fromLeft = $c;

$layer = min($fromTop, $fromBottom, $fromLeft, $fromRight);

$value = getFullSquaresSum($n, $layer);

while(true) {
    $size = $n - ($layer * 2) + 1;

    // Position is on the top of the square
    if($fromTop == $layer) {
        $value += $c - $layer + 1; 
        break;
    } else $value += $size;

    // Position is on the right of the square
    if($fromRight == $layer) {
        $value += $r - $layer + 1; 
        break;
    } else $value += $size;

    // Position is on the bottom of the square
    if($fromBottom == $layer) {
        $value += $n - $c + 1 - $layer + 1; 
        break;
    } else $value += $size;

    // Position is on the left of the square
    if($fromLeft == $layer) {
        $value += $n - $r + 1 - $layer + 1; 
        break;
    }
}

echo $value . PHP_EOL;

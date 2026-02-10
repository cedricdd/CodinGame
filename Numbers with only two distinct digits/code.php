<?php

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d %d", $a, $b);

// We know that the number will always be even
$number = ($a % 2 == 0) ? $a : $b;

/**
 * We build the number from right to left using modular arithmetic.
 * After k steps, the current suffix is divisible by 2^k; since 10^k is also divisible by 2^k, prepending a digit only affects divisibility by the next factor of 2.
 */
for($i = 2; $i <= $n; ++$i) {
    if(bcmod($a . $number, bcpow("2", $i)) === "0") $number = $a . $number;
    else $number = $b . $number;
}

echo $number . PHP_EOL;

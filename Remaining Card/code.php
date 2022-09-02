<?php

/**
 * We can see that the result is correlated the the binary representation of N
 * If N is a power of 2 then the result is N
 * Otherwise ignore the leftmost bit and by reading from right to left do the sum of bit * 2^position
 * 
 * Example 186 is 10111010
 * So result is 0 * 2^1 + 1 * 2^2 + 0 * 2^3 + 1 * 2^4 + 1 * 2^5 + 1 * 2^6 + 0 * 2^7 = 116
 */

fscanf(STDIN, "%d", $N);

$binary = decbin($N);
$ans = 0;

//It's a power of 2
if(array_sum(str_split($binary)) == 1) $ans = $N;
else {
    for($i = strlen($binary) - 1; $i > 0; --$i) {
        $ans += $binary[$i] * 2 ** (strlen($binary) - $i);
    }
}

echo $ans . PHP_EOL;
?>

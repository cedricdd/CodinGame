<?php

/**
 * To generate the order n+1 we just need to use the order n, add a '1' and add the order n in reverse where 0 & 1 are switched.
 * 1 - 1
 * 2 - 1 . 1 . 0
 * 3 - 110 . 1 . 100
 * 4 - 1101100 . 1 . 1100100
 * 
 * We can't just generate everything up to order 50, it would take too much memory
 * 
 * https://en.wikipedia.org/wiki/Regular_paperfolding_sequence
 * The value of any given term n in the regular paperfolding sequence, starting with n = 1, can be found recursively as follows. 
 * Divide n by two, as many times as possible, to get a factorization of the form n = m ⋅ 2 k where m is an odd number. 
 * Then m % 4 will either by 1 or 3 because m is always odd, if it's 1 the value is 1, if it's 3 the value is 0; 
 */

fscanf(STDIN, "%d", $order);
fscanf(STDIN, "%d %d", $S, $E);

for($i = $S + 1; $i <= $E + 1; ++$i) {
    $m = $i;

    while(!($m & 1)) $m >>= 1; //Divide by 2 until m is odd

    echo ($m % 4 == 1) ? "1" : "0"; 
}

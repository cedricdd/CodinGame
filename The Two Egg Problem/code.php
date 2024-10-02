<?php

/**
 * We use the first egg to minimize the number of floors left to check after it breaks.
 * We also need to minimize the number of max tries before the first egg will broke.
 * If we pick floor evenly spaced for the first egg the remaining floors when the first egg breaks will always be the same
 * so the worst case will be when the first egg breaks on the last possiblity.
 * If after each tries of the first egg we decrease the interval by one we get intervals: x ; x - 1 ; x - 2 ; ... ; 1
 * That way the more tries we do with the first egg, the less have to do with the second, the worst case is the same for all intervals.
 * 
 * We want to find the smallest x such as the sum from 1 to x is >= N
 * => x (x - 1) / 2 >= N 
 * => x² - x - 2N >= 0
 * We can solve this with the quadratic formula.
 */

fscanf(STDIN, "%d", $N);

echo ceil((-1 + sqrt(1 + 8 * $N)) / 2) . PHP_EOL;

<?php

//count[i] = count[i - 1] + (9 ^ i)
const COUNTS = array (
    0 => 0,
    1 => 9,
    2 => 90,
    3 => 819,
    4 => 7380,
    5 => 66429,
    6 => 597870,
    7 => 5380839,
    8 => 48427560,
    9 => 435848049,
    10 => 3922632450,
    11 => 35303692059,
    12 => 317733228540,
    13 => 2859599056869,
    14 => 25736391511830,
    15 => 231627523606479,
    16 => 2084647712458320,
    17 => 18761829412124889,
    18 => 168856464709124010,
    19 => 1519708182382116099,
);

function solve(string $n): string {
    $solution = "";

    //We search for the value of the digit at position i, from left to right
    for($i = 20; $i > 0; --$i) {
        $d = 0;

        /**
         * Find the value of the digit at position $i
         * COUNTS[$i - 1] is how many solid integer we are sure to have before adding any digit at position $i
         * By adding X at position $i we will be adding X * (9 ^ ($i - 1)) extra solid integers
         */
        while(COUNTS[$i - 1] + ($d * (9 ** ($i - 1))) < $n) {
            ++$d;
        }

        $solution .= $d;

        $n -= $d * (9 ** ($i - 1)); //Update the number of solid integers we still want to add
    }

    return $solution;
}

$n = stream_get_line(STDIN, 256 + 1, "\n");

echo trim(solve($n), '0') . PHP_EOL;

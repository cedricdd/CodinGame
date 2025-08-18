<?php

const SQUARES = [0 => 0,1 => 1,2 => 4,3 => 9,4 => 16,5 => 25,6 => 36,7 => 49,8 => 64,9 => 81];
const HAPPY = [1 => 1,7 => 1,10 => 1,13 => 1,19 => 1,23 => 1,28 => 1,31 => 1,32 => 1,44 => 1,49 => 1,68 => 1,70 => 1,79 => 1,82 => 1,86 => 1,91 => 1,94 => 1,97 => 1,100 => 1,103 => 1,109 => 1,129 => 1,130 => 1,133 => 1,139 => 1,167 => 1,176 => 1,188 => 1,190 => 1,192 => 1,193 => 1,203 => 1,208 => 1,219 => 1,226 => 1,230 => 1,236 => 1,  239 => 1,262 => 1,263 => 1,280 => 1,291 => 1,293 => 1,301 => 1,302 => 1,310 => 1,313 => 1,319 => 1,320 => 1];

$start = microtime(1);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $input = stream_get_line(STDIN, 128 + 1, "\n");

    /**
     * Numbers are capped by 10^26 so worst case we will have 26 digits (every power of 10 is happy), 26*81 = 2106
     * After first turn we are sure to have at max 2106, 4*81 = 324, after second turn we are sure to have at max 324
     * Just precompute all the happy numbers <= 324 and we know if any numbers is happy or not after 2 turns.
     */
    $sum = $input;

    while($sum > 324) {
        $sum = array_sum(array_map(function($d) {
            return SQUARES[$d];
        }, str_split($sum)));
    }

    echo $input . (isset(HAPPY[$sum]) ? " :)\n" : " :(\n");
}

error_log(microtime(1) - $start);

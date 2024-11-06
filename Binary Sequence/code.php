<?php

function solve(int $index): int {
    if($index < 2) return $index;

    $bits = 1;
    $first = 2;

    /**
     * With 1 bit we have 2 numbers => 2 bits total
     * With 2 bits we have 2 numbers => 2 + 2 * 2 = 6 bits total
     * With 3 bits we have 4 numbers => 6 + 4 * 3 = 18 bits total
     * With 4 bits we have 8 numbers => 18 + 8 * 4 = 50 bits total
     * ...
     * 
     * We start by searching the size of the integer using the index $index
     */
    while(true) {
        ++$bits;

        $count = $bits * (2 ** ($bits - 1));
        if($first + $count > $index) break;
        else $first += $count;
    }

    //2 ** ($bits - 1) is the first integer of $bits size
    $count = floor(($index - $first) / $bits); //How many integers are before the one using index $index
    $integer = 2 ** ($bits - 1) + $count; 

    $index -= $first + ($count * $bits); //Convert $index from the sequence to the index from the integer

    return str_split(decbin($integer))[$index];
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $index = bindec(trim(fgets(STDIN)));

    echo solve($index) . PHP_EOL;
}

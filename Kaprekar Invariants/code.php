<?php

const ALPHABET = "0123456789abcdefghijklmnopqrstuvwxyz";

function permutations(int $start, string $number, int $count) {
    global $solutions, $d, $n;

    //We have generated a permutation, check it
    if($count == $d) {
        //Calculate the difference between max and min
        $value = base_convert(base_convert(strrev($number), $n, 10) - base_convert($number, $n, 10), 10, $n);

        //We are using the same digits
        if(count_chars($number, 1) == count_chars($value, 1)) $solutions[] = strtoupper($value);

        return;
    }

    for($i = $start; $i < $n; ++$i) {
        //We can only use values that are >= of the last value used.
        //1234, 2341, 3412, 1432, ... they would all would all generate the same max & min numbers
        permutations($i, $number . ALPHABET[$i], $count + 1);
    }
}

$start = microtime(1);

$solutions = [];

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $d);

permutations(0, "", 0);

$count = count($solutions);

if($count == 0) echo "0" . PHP_EOL;
else {
    sort($solutions);
    echo $count . PHP_EOL . implode(PHP_EOL, $solutions) . PHP_EOL;
}

error_log(microtime(1) - $start);

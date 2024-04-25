<?php

$start = microtime(1);

/**
 * We want to solve A^N < N!
 * To make sure the values don't get too high we use log so we need to solve: log(A^N) < log(N!)
 * log(A^N) = N * log(A)
 * log(N!) = log(1) + log(2) + log(3) + ... + log(N)
 */
function solve(float $value): int {
    $log = log($value);
    $factorial = 0;
    $n = 1;

    while($n * $log >= $factorial) {
        $n += 1;
        $factorial += log($n);
    }

    return $n;
}

fscanf(STDIN, "%d", $K);

foreach(explode(" ", trim(fgets(STDIN))) as $value) {
    $solutions[] = solve($value);
}

echo implode(" ", $solutions) . PHP_EOL;

error_log(microtime(1) - $start);

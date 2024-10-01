<?php

/**
 * The sum N of the k consecutive odd numbers starting at s is:
 * N = s + (s + 2) + (s + 4) + ... + (s + (k - 1) * 2)
 * N = k * s + 2 (0 + 1 + 2 + 3 + (k - 1))
 * The sum from 1 to n is n(n + 1) / 2
 * N = k * s + 2 * ((k - 1) * k / 2)
 * N = k * (s + k - 1)
 * 
 * s = (N - (k - 1) * k) / k
 * 
 * For each k we can calculate the start, it's valid if it's odd & an integer
 * For the lower bound of k we need at least 2 consecutive so it will be 2
 * For the upper bound of k we need N - (k - 1) * k > 0 => k² − k - N < 0
 * Using the Quadratic Formula, since k needs to be positive we use the positive root => kmax = (1 + sqrt(1 + 4 * N)) / 2
 */

fscanf(STDIN, "%d", $n);

$solutions = [];

$upper = (1 + sqrt(1 + 4 * $n)) / 2;

for($k = 2; $k <= $upper; ++$k) {
    $numerator = $n - ($k - 1) * $k;

    if($numerator % $k == 0) {
        $start = $numerator / $k;

        if($start & 1) $solutions[] = $start . " " . ($start + ($k - 1) * 2);
    }
}

$count = count($solutions);

if($count == 0) echo "0" . PHP_EOL;
else echo $count . PHP_EOL . end($solutions) . PHP_EOL;

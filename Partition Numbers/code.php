<?php

function solve(int $n): array {
    // Create an array to store the number of partitions for each number up to n
    $partitions = array_fill(0, $n + 1, 0);
    $partitions[0] = 1;  // There's one way to partition 0 (the empty partition)

    // Iterate through each number from 1 to n to build up the partitions array
    for ($i = 1; $i <= $n; $i++) {
        for ($j = $i; $j <= $n; $j++) {
            $partitions[$j] += $partitions[$j - $i];
        }
    }

    // The number of partitions of n is now stored in $partitions[$n]
    return $partitions;
}

fscanf(STDIN, "%d", $T);
for ($i = 0; $i < $T; $i++) {
    $inputs[] = intval(trim(fgets(STDIN)));
}

$results = solve(max($inputs));

foreach($inputs as $n) echo $results[$n] . PHP_EOL;

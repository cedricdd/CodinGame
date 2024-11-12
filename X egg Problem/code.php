<?php

function minTrials($n, $k) {
    $dp = array_fill(0, $n + 1, 0);
    $m = 0;

    while ($dp[$n] < $k) {
        $m++;
        for ($x = $n; $x > 0; $x--) {
            $dp[$x] += 1 + $dp[$x - 1];
        }
    }

    return $m;
}
$start = microtime(1);

fscanf(STDIN, "%d", $floors);
fscanf(STDIN, "%d", $eggs);

echo minTrials($eggs, $floors) . PHP_EOL;

error_log(microtime(1) - $start);

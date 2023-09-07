<?php

const COINS = [[50, 11.340], [25, 5.670], [10, 2.268], [5, 5.0], [1, 2.5]];

function solve(int $index, int $left, int $sum): array {
    static $history = [];

    if(isset($history[$index][$left][$sum])) return $history[$index][$left][$sum];

    $min = INF;
    $max = -INF;
    $count = 0;

    for($i = $index; $i < 5; ++$i) {
        if(COINS[$i][0] > $sum) continue; //Coin is too big
        if(COINS[$i][0] * $left < $sum) break; //We can no longer reach the sum

        //We only need one more coin
        if($left == 1) {
            if($sum == COINS[$i][0]) return [COINS[$i][1], COINS[$i][1], 1];

            break;
        }

        //We use coin $i
        [$min2, $max2, $count2] = solve($i, $left - 1, $sum - COINS[$i][0]);

        //If we can reach the sum after using coin $i, update the values
        if($count2 != 0) {
            $count += $count2;
            if($min2 + COINS[$i][1] < $min) $min = $min2 + COINS[$i][1];
            if($max2 + COINS[$i][1] > $max) $max = $max2 + COINS[$i][1];
        }
    }

    return $history[$index][$left][$sum] = [$min, $max, $count];
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    preg_match("/\(([0-9]+)\) ([0-9]+) coins \\$([0-9.]+)/", trim(fgets(STDIN)), $matches);

    [$min, $max, $total] = solve(0, $matches[2], $matches[3] * 100);

    if($min == INF) echo "(" . $matches[1] . ") Impossible" . PHP_EOL;
    elseif($min == $max) echo "(" . $matches[1] . ") 1 option of " . number_format($min, 3, ".", "") . " g" . PHP_EOL;
    else echo "(" . $matches[1] . ") $total options from " . number_format($min, 3, ".", "") . " g to " . number_format($max, 3, ".", "") . " g" . PHP_EOL;

    error_log(microtime(1) - $start);
}

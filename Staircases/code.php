<?php

fscanf(STDIN, "%d", $N);

$history = [];

function solve(int $level, int $left): int {
    global $history;

    if($left == 0) return 1;
    if($left <= $level) return 0;
    if(isset($history[$level][$left])) return $history[$level][$left];

    $solutions = 0;

    for($i = $level + 1; $i <= $left; ++$i) {
        $solutions += solve($i, $left - $i);
    }

    return $history[$level][$left] = $solutions;
}

echo solve(0, $N) - 1 . PHP_EOL;

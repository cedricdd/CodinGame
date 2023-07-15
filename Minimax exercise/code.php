<?php

function solve(int $start, int $depth): int {
    global $leafs, $explored, $D, $B;

    ++$explored;

    if($depth == $D) return $leafs[$start];

    $value = ($depth % 2 == 0) ? -INF : INF;

    for($i = 0; $i < $B; ++$i) {
        if($depth % 2 == 0) $value = max($value, solve($start + ($i * ($B ** ($D - $depth - 1))), $depth + 1));
        else $value = min($value, solve($start + ($i * ($B ** ($D - $depth - 1))), $depth + 1));
    }

    return $value;
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $D, $B);
$leafs = explode(" ", trim(fgets(STDIN)));

$explored = 0;

echo solve(0, 0) . " " . $explored . PHP_EOL;

error_log(microtime(1) - $start);

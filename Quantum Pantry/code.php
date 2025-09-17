<?php

/**
 * We are just testing all the possible ways to open the jars
 */
function solve(array $jars, int $total): int {
    $best = $total;

    foreach($jars as $i => [$L, $H, $T]) {
        unset($jars[$i]);

        if($total < $T) $result = solve($jars, $total + $L);
        else $result = solve($jars, $total + $H);

        if($result > $best) $best = $result;

        $jars[] = [$L, $H, $T];
    }

    return $best;
}

$jars = [];
$bestFirst = [];
$bestAfter = [];
$max = 0;
$additional = 0;
$start = microtime(1);

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d %d", $L, $H, $T);

    $test[] = [$L, $H, $T];

    // Imposible to use $L or it doesn't matter when we open it
    if($T == 0 || $L == $H) {
        $additional += $H;
        $max += $H;
    } else {
        $max += max($L, $H);

        $jars[] = [$L, $H, $T];
    }
}

foreach($jars as $i => [$L, $H, $T]) {
    // Impossible to reach T, we know it will be L
    if($T > ($max - max($L, $H))) {
        $additional += $L;
    } else {
        if($L > $H) $bestFirst[] = [$L, $H, $T]; //The L value is better we want to try to open it early
        else $bestAfter[] = [$L, $H, $T]; //The H value is better we want to try to open it late
    }
}

unset($jars);

$total = solve($bestFirst, 0); //Find the best solution for the jars where L is better
$total += $additional; //Add everything that is forced
$total = solve($bestAfter, $total); //Find the best solution for the jars where H is better

echo $total . PHP_EOL;

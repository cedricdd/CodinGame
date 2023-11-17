<?php

function solve(int $n, int $integer, string $solution) {
    global $solutions;

    if($n == 0) {
        $solutions[] = $solution;
        return;
    }

    for($i = min($n, $integer); $i > 0; --$i) {
        solve($n - $i, $i, $solution . " " . $i);
    }
}

fscanf(STDIN, "%d", $n);

solve($n, $n, "");

arsort($solutions);

echo implode(PHP_EOL, array_map('trim', $solutions)) . PHP_EOL;

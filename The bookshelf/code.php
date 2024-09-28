<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $H[], $W[]);
}

$heightMax = max($H);
$output = array_fill(0, $heightMax + 1, str_repeat(" ", array_sum($W) + $N * 2));

$index = 0;
for($i = 0; $i < $N; ++$i) {
    for($j = 0; $j < $H[$i]; ++$j) {
        $output[$heightMax - $j][$index] = '|';
        $output[$heightMax - $j][$index + $W[$i] + 1] = '|';
    }
    for($j = 0; $j < $W[$i]; ++$j) {
        $output[$heightMax][$index + 1 + $j] = '_';
        $output[$heightMax - $H[$i]][$index + 1 + $j] = '_';
    }

    $index += $W[$i] + 2;
}

echo implode(PHP_EOL, array_map("rtrim", $output)) . PHP_EOL;

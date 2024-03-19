<?php

fscanf(STDIN, "%d", $N);

$steps = [range(1, $N)];

for($i = 1; $i <= $N; ++$i) {
    $list = [];

    for($j = 0; $j < $N; ++$j) {
        //We alternate from the end and the start of the array
        $index = $j >> 1;
        if($j % 2 == 0) $index = $N - $index - 1;
        $list[] = $steps[$i - 1][$index];
    }

    $steps[] = $list;
}

if($steps[$N] == $steps[0]) {
    echo implode("\n", array_map(function($step) {
        return implode(",", $step);
    }, array_slice($steps, 1))) . PHP_EOL;
} else echo "IMPOSSIBLE" . PHP_EOL;

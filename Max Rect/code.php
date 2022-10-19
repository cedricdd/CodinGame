<?php

//Using Kadane's algorithm
//https://en.wikipedia.org/wiki/Maximum_subarray_problem
function kadane(array $sums): int {
    for($i = 0; $i < count($sums); ++$i) {
        $best[$i] = max($sums[$i], ($best[$i - 1] ?? 0) + $sums[$i]);
    }

    return max($best);
}

$max = -INF;

fscanf(STDIN, "%d %d", $W, $H);
for ($y = 0; $y < $H; ++$y) {
    $grid[] = array_map("intval", explode(" ", trim(fgets(STDIN))));
}

for($left = 0; $left < $W; ++$left) {
    $sums = array_fill(0, $H, 0);

    for($right = $left; $right < $W; ++$right) {
        $sums = array_map(function ($a1, $a2) { return $a1 + $a2; }, $sums, array_column($grid, $right));
        $max = max($max, kadane($sums));
    }
}

echo $max . PHP_EOL;

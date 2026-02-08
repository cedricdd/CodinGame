<?php

$grid = [];

fscanf(STDIN, "%d %d", $W, $H);
fscanf(STDIN, "%d", $K);
for ($y = 0; $y < $H; ++$y) {
    $grid[$y] = trim(fgets(STDIN));

    foreach(str_split($grid[$y]) as $x => $c) {
        if(ctype_digit($c)) {
            $threshold = max(0, $y - ($K * $c));

            for($y2 = $y - 1; $y2 >= $threshold; --$y2) {
                $grid[$y2][$x] = '.';
            }
        }
    }
}

echo (substr_count(implode('', $grid), 'P') * 100) . PHP_EOL;

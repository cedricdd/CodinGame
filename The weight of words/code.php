<?php

fscanf(STDIN, "%d", $steps);
fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
for ($i = 0; $i < $h; $i++) {
    $grid[] = array_map("ord", str_split(trim(fgets(STDIN))));
}

for($step = 0; $step < $steps; ++$step) {
    $newGrid = [];
    //for each of the w columns
    for($x = 0; $x < $w; ++$x) {
        $sum = 0;
        for($y = 0; $y < $h; ++$y) $sum += $grid[$y][$x];
        for($y = 0; $y < $h; ++$y) $newGrid[($y + $sum) % $h][$x] = $grid[$y][$x];
    }

    $grid = $newGrid;
    $newGrid = [];
    //for each of the h rows
    for($y = 0; $y < $h; ++$y) {
        $sum = 0;
        for($x = 0; $x < $w; ++$x) $sum += $grid[$y][$x];
        for($x = 0; $x < $w; ++$x) $newGrid[$y][($x + $sum) % $w] = $grid[$y][$x];
    }

    $grid = $newGrid;
}

ksort($grid); //Sort in the proper order before outputting it

echo implode("\n", array_map(function($line) {
    ksort($line); //Sort in the proper order before outputting it
    return implode("", array_map("chr", $line));
}, $grid)) . PHP_EOL;
?>

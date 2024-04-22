<?php

$alphabet = array_flip(range('a', 'z'));
$grid = "";

fscanf(STDIN, "%d", $ii);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $grid .= trim(fgets(STDIN));
}

$size = $n * $n;
$index = 0;
$indexHistory = 0;
$history = [];
$historyIndex = [];

while(--$ii) {
    //We are in a loop
    if(isset($historyIndex[$grid][$index])) {
        $repetition = array_slice($history, $historyIndex[$grid][$index]);

        exit($repetition[$ii % count($repetition)]);
    } //Save info to detect loops
    else {
        $historyIndex[$grid][$index] = $indexHistory++;
        $history[] = $grid[$index];
    }

    //rotate the grid 90° clockwise
    if($grid[$index] == '#') {
        $gridOld = $grid;

        for($x = 0; $x < $n; ++$x) {
            for($y = $n - 1; $y >= 0; --$y) {
                $grid[$x * $n + ($n - $y - 1)] = $gridOld[$y * $n + $x];
            }
        }
    } //rotate the grid by 90° counter-clockwise
    elseif($grid[$index] == '@') {
        $gridOld = $grid;

        for($x = $n - 1; $x >= 0; --$x) {
            for($y = 0; $y < $n; ++$y) {
                $grid[($n - $x - 1) * $n + $y] = $gridOld[$y * $n + $x];
            }
        }
    }

    $index = ($index + $alphabet[$grid[$index]] + 1) % $size; //Move to the next position
}

echo $grid[$index] . PHP_EOL;

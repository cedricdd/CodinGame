<?php

function explore(int $position, int $count) {
    global $n, $goal, $snakes, $ladders, $solution;
    static $history = [];

    if($count >= $solution) return; // Can't read the end with less dice roll

    if($position == $goal) {
        $solution = $count;
        return;
    }

    // Don't get stuck in a loop
    if(isset($history[$position]) && $history[$position] <= $count) return;
    else $history[$position] = $count;


    $max = min($position + $n, $goal);
    $basic = null;

    for($p = $position + 1; $p <= $max; ++$p) {
        if(isset($ladders[$p])) explore($ladders[$p], $count + 1);
        elseif(isset($snakes[$p])) explore($snakes[$p], $count + 1);
        else $basic = $p;
    }

    // We also try the further away position that's not the head of a snake or the bottom of a ladder
    if($basic !== null) explore($basic, $count + 1);
}

$start = microtime(1);
 
fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d %d", $snakeAmount, $ladderAmount);

$goal = $width * $height;

for ($i = 0; $i < $snakeAmount; $i++) {
    fscanf(STDIN, "%d %d", $head, $tail);

    $snakes[$head] = $tail;
}

for ($i = 0; $i < $ladderAmount; $i++) {
    fscanf(STDIN, "%d %d", $top, $bottom);

    $ladders[$bottom] = $top;
}

$solution = INF;

explore(1, 0);

echo $solution . PHP_EOL;

error_log(microtime(1) - $start);

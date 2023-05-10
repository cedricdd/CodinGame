<?php

$leaks = [];

fscanf(STDIN, "%d", $S);
fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $flow);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d", $leakHeight, $leakFlow);

    $leaks[] = [$leakHeight, $leakFlow];
}

//Sort leaks from bottom to top
usort($leaks, function($a, $b) {
    return $a[0] <=> $b[0];
});

$leaks[] = [$h, 0]; //Sets the top as a leak

$height = 0;
$time = 0;

foreach($leaks as [$h, $f]) {
    $time += (($h - $height) * $S * 0.001) / $flow; //The time it takes to fill from current height up to the start of the leak

    if(($flow -= $f) <= 0) exit("Impossible, $h cm."); //The flow decrease by leak flow

    $height = $h;
}

echo sprintf("%02d", intval($time / 60)) . ":" . sprintf("%02d", intval($time) % 60) . ":" . sprintf("%02d", floor(60 * ($time - intval($time)))) . PHP_EOL;

<?php

$start = microtime(1);

//Get the cost after the jump from point A to point B
function getJumpCost(int $xa, int $ya, int $xb, int $yb): int {
    global $costs, $map;

    return $costs[max(abs($xa - $xb), abs($ya - $yb)) - 1] + $map[$yb][$xb];
}

fscanf(STDIN, "%d", $n);

$lastPosition = $n * $n - 1;
$costs = explode(" ", trim(fgets(STDIN)));

for ($i = 0; $i < $n; $i++) {
    $map[] = trim(fgets(STDIN));
}

//Initial values are the direct jump from position 0
for($y = 0; $y < $n; ++$y) {
    for($x = 0; $x < $n; ++$x) {
        if($x == 0 && $y == 0) continue;

        $jumps[] = [$map[0][0] + getJumpCost(0, 0, $x, $y), $x, $y];
    }
}

$indexToCheck = 0;

while(1) {
    [$currentCost, $x, $y] = $jumps[$indexToCheck];

    //We have reach the destination
    if($y * $n + $x == $lastPosition) {
        error_log(var_export(microtime(1) - $start, true));
        exit("$currentCost");
    }

    unset($jumps[$indexToCheck]);
    $min = INF;

    //Foreach position we haven't reached yet, check if we can reach them with smaller cost
    foreach($jumps as $index => [&$cost, $xj, $yj]) {
        $jumpCost = $currentCost + getJumpCost($x, $y, $xj, $yj);

        if($jumpCost < $cost) $cost = $jumpCost;

        //At the same time we look for the next index to check (ie the position we can reach with the lowest cost)
        if($cost < $min) {
            $min = $cost;
            $indexToCheck = $index;
        }
    }
}

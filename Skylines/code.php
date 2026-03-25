<?php

function getSkyline(array $buildings): array {
    $events = [];

    //Step 1: Create events
    foreach ($buildings as [$h, $x1, $x2]) {
        $events[] = [$x1, -$h]; //Start
        $events[] = [$x2, $h];  //End
    }

    //Step 2: Sort events
    usort($events, function($a, $b) {
        if ($a[0] === $b[0]) return $a[1] <=> $b[1];
        return $a[0] <=> $b[0];
    });

    $heights = [0 => 1];
    $result = [];
    $prevMax = 0;

    foreach ($events as [$x, $h]) {
        if ($h < 0) { //Starting a building
            $h = -$h;
            $heights[$h] = ($heights[$h] ?? 0) + 1;
        } else { //Ending a building
            if (--$heights[$h] === 0) unset($heights[$h]);
        }

        $currentMax = max(array_keys($heights));

        //Change of direction (going to the floor or increasing size)
        if ($currentMax !== $prevMax) {
            $result[] = [$x, $currentMax];
            $prevMax = $currentMax;
        }
    }

    return $result;
}

function countLines(array $skyline): int {
    $lines = 0;
    $count = count($skyline);

    for ($i = 0; $i < $count; $i++) {
        [$x1, $h1] = $skyline[$i];

        if ($h1 == 0) $lines++; //We are going for the floor, just one line
        else $lines += 2 + ($i > 0 && $skyline[$i - 1][1] == 0); //We are going up & left, two lines, plus one if we were previously on the floor
    }

    return $lines;
}

$buildings = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %d %d", $h, $x1, $x2);

    $buildings[] = [$h, $x1, $x2];
}

$skylines = getSkyline($buildings);

echo countLines($skylines) . PHP_EOL;

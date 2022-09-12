<?php

$points = [];
fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    //Calculate the distance to the other points
    foreach($points as $j => [$x2, $y2]) {
        $distance = sqrt(($x - $x2) ** 2 + ($y - $y2) ** 2);
        $distances[$i][$j] = $distances[$j][$i] = $distance;
    }

    $points[] = [$x, $y];
}

$visited = [0 => 1]; //We only move back to the starting point at the end
$total = 0;
$position = 0;

while(count($visited) != $N) {
    //Sort by closest
    asort($distances[$position]);

    foreach($distances[$position] as $point => $distance) {
        //Move to the closest point we haven't visited yet
        if(!isset($visited[$point])) {
            $position = $point;
            $total += $distance;
            $visited[$point] = 1;
            continue 2;
        }
    }
}

echo round($total + $distances[$position][0]) . PHP_EOL;
?>

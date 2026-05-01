<?php

function solve(int $position, int $time) {
    global $junctions, $links, $endPosition, $maxEnd;
    static $history = [];

    if($position == $endPosition) die("true"); //There's a path to the end position

    if(isset($history[$position][$time])) return; 
    else $history[$position][$time] = true;

    foreach(($links[$position] ?? []) as $newPosition => $duration) {
        $newTime = min($maxEnd, $time + $duration); //After max end we won't be able to pass any junctions with a time window so all the times produce the same result

        //The junction can always be passed of we are withing the time window
        if(!isset($junctions[$newPosition]) || ($newTime >= $junctions[$newPosition][0] && $newTime <= $junctions[$newPosition][1])) {
            solve($newPosition, $newTime);
        } 
    }
}

fscanf(STDIN, "%d %d %d", $n, $m, $ntw);
fscanf(STDIN, "%d %d", $startPosition, $endPosition);

$maxEnd = 0;

for ($i = 0; $i < $ntw; $i++){
    fscanf(STDIN, "%d %d %d", $id, $start, $end);

    $junctions[$id] = [$start, $end];

    if($end > $maxEnd) $maxEnd = $end;
}

for ($i = 0; $i < $m; $i++){
    fscanf(STDIN, "%d %d %d", $i1, $i2, $duration);

    $links[$i1][$i2] = $duration;
}

solve($startPosition, 0);

echo "false" . PHP_EOL;

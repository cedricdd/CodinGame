<?php

fscanf(STDIN, "%d", $L);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    [$plate, $distance, $timestamp] = explode(" ", trim(fgets(STDIN)));

    $cars[$plate][] = [$distance, $timestamp];
}

$speeding = [];

foreach($cars as $plate => $info) {
    if(count($info) <= 1) continue; //Not enough info to know if the car is speeding

    //Sort by distance from the begining of the road ASC
    usort($info, function($a, $b) {
        return $a[0] <=> $b[0];
    });


    for($i = 1; $i < count($info); ++$i) {
        //Check if the time it took the car is lower than what it would have taken by going at max speed
        if(($info[$i][1] - $info[$i - 1][1]) < (($info[$i][0] - $info[$i - 1][0]) * 3600 / $L)) {
            $speeding[] = $plate . " " . $info[$i][0];
        }
    }
}

if(count($speeding) > 0) echo implode("\n", $speeding) . PHP_EOL;
else echo "OK" . PHP_EOL;

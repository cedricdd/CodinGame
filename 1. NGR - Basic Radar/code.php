<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    [$plate, $radarname, $timestamp] = explode(" ", trim(fgets(STDIN)));
    $plates[$plate][$radarname] = $timestamp;
}

ksort($plates, SORT_NATURAL); //Results are ordered alphabetically by Plate

foreach($plates as $plate => $radars) {
    //Just convert the time in hour and check if in a full hour the car will travel more than 130km
    if(($speed = intval(13 / (($radars["A21-55"] - $radars["A21-42"]) / 3600000))) > 130) {
        echo $plate . " " . $speed . PHP_EOL;
    }
}

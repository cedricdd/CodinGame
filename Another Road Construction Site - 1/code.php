<?php

fscanf(STDIN, "%d", $roadLength);

$normalSpeed = $roadLength / 130 * 60;
$reducedSpeed = 0;

fscanf(STDIN, "%d", $zoneQuantity);
for ($i = 0; $i < $zoneQuantity; $i++) {
    fscanf(STDIN, "%d %d", $zoneKm, $zoneSpeed);

    $zones[] = [$zoneKm, $zoneSpeed];

    //Calculate the time up to the start of this zone
    $reducedSpeed += ($zoneKm - ($zones[$i - 1][0] ?? 0)) / ($zones[$i - 1][1] ?? 130);
    //Last zone, it will last until the end of the road
    if($i == $zoneQuantity - 1) $reducedSpeed += ($roadLength - $zoneKm) / $zoneSpeed;
}

echo round(($reducedSpeed * 60) - $normalSpeed) . PHP_EOL;

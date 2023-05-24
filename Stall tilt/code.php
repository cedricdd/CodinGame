<?php

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $v);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d", $speed);

    $motorcycles[chr($i + 97)] = $speed;
}
for ($i = 0; $i < $v; $i++) {
    fscanf(STDIN, "%d", $bends[]);
}

$maxSpeed = INF;
$order = [];
arsort($motorcycles);

foreach($bends as $bend) {
    $falls = [];

    //angle needs to be >= 90-30, find the speed when the angle is at the limit of falling
    //tan(θ) = v² / (r × g) => v = sqrt(tan(θ)) * (r * g))
    $max = floor(sqrt(tan(deg2rad(90 - 30)) * ($bend * 9.81)));

    //Check if any motorcycle is going too fast for this bend
    foreach($motorcycles as $index => $speed) {
        if($speed > $max) {
            $falls[$index] = 1;
            unset($motorcycles[$index]);
        }
    }

    $order = array_merge($falls, $order);
    $maxSpeed = min($max, $maxSpeed);
}

$order = array_merge($motorcycles, $order); //Add the motorcycles that didn't fall

echo $maxSpeed . PHP_EOL . "y" . PHP_EOL . implode("\n", array_keys($order)) . PHP_EOL;

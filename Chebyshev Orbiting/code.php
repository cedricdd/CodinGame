<?php

fscanf(STDIN, "%d %d %d %d %d %d", $radius, $x, $y, $vx, $vy, $time);

$history = [];

while($time--) {
    if(!isset($history["$x $y $vx $vy"])) $history["$x $y $vx $vy"] = "$x $y 0";
    //We are in a loop
    else exit(array_values($history)[($time % count($history)) + 1]);

    //Update spaceship coordinate
    $x += $vx;
    $y += $vy;

    //Update velocity
    if($x > 0) $vx--;
    elseif($x < 0) $vx++;
    if($y > 0) $vy--;
    elseif($y < 0) $vy++;

    //Check if spaceship crashed 
    if(max(abs($x), abs($y)) <= $radius) exit("$x $y 1");
}

echo "$x $y 0" . PHP_EOL;

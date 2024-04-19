<?php

function solve(float $max, array $volumes, array $wraps) {
    global $solution;

    $volume = array_pop($volumes);
    $count = count($wraps);

    if($count > $solution) return; //We already have a better solution
    elseif($volume === null) { //We have wrapped everything
        if($count < $solution) $solution = $count ;

        return;
    } 

    //Try to add the item in any of the existing wrap
    foreach($wraps as $i => $wrap) {
        if($wrap + $volume <= $max) {
            $wraps[$i] += $volume;

            solve($max, $volumes, $wraps);

            $wraps[$i] -= $volume;
        }
    }

    $wraps[] = $volume;
    solve($max, $volumes, $wraps);
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $n, $k);
$volumes = explode(" ", fgets(STDIN));
$solution = INF;

sort($volumes); //We use array_pop, we want the biggest items at the end

solve($k, $volumes, []);

echo $solution . PHP_EOL;

error_log(microtime(1) - $start);

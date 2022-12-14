<?php

//Check if 2 points are in the same orthant
function isSameOrthant(array $p1, array $p2): bool {

    for($i = 1; $i < count($p1); ++$i) {
        if($p1[$i] > 0 && $p2[$i] < 0 || $p1[$i] < 0 && $p2[$i] > 0) return false; 
    }

    return true;
}

//Get the distance between 2 points
function getDistance(array $p1, array $p2): float {
    $distance = 0.0;

    for($i = 1; $i < count($p1); ++$i) {
        $distance += pow($p1[$i] - $p2[$i], 2);
    }

    return sqrt($distance);
}

fscanf(STDIN, "%d %d", $count, $n);

$points = [array_fill(0, $n + 1, 0)];
$distances = [];

for ($i = 1; $i <= $count; $i++) {
    $inputs = explode(" ", trim(fgets(STDIN)));

    //Get the distance between this point and the others we already know
    foreach($points as $index => $point) {
        $distance = getDistance($point, $inputs);

        $distances[$index][$i] = $distance;
        $distances[$i][$index] = $distance;
    }

    $points[] = $inputs;
}

//The first point is the closest to the origin
$position = array_search(min($distances[0]), $distances[0]);
$answer = "";
$visited = [0];

while(true) {
    $visited[$position] = 1;
    $answer .= $points[$position][0];

    asort($distances[$position]);

    foreach($distances[$position] as $destination => $distance) {
        //We visit each points only once
        if(!isset($visited[$destination])) {
            //If we are changing orthant we need to add a space
            if(!isSameOrthant($points[$position], $points[$destination])) $answer .= " ";

            $position = $destination;
        
            continue 2;
        }
    }

    break; //We have visited all the points
}

echo $answer . PHP_EOL;

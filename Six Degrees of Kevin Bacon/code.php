<?php

$actorName = trim(fgets(STDIN));

if($actorName == "Kevin Bacon") exit("0");

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    [$movie, $cast] = explode(":", trim(fgets(STDIN)));
    $cast = array_map("trim", explode(",", $cast));

    foreach($cast as $name) $actors[$name][$movie] = 1;
    $movies[$movie] = $cast;
}

$number = 1;
$history = [];
$toCheck = [$actorName];

while(true) {
    $newCheck = [];

    foreach($toCheck as $actorName) {
        if(isset($history[$actorName])) continue;
        else $history[$actorName] = 1;

        foreach($actors[$actorName] as $movieName => $filler) {
            if(isset($actors["Kevin Bacon"][$movieName])) break 3;

            $newCheck = array_merge($newCheck, $movies[$movieName]);
        }
    }

    ++$number;
    $toCheck = $newCheck;
}

echo $number . PHP_EOL;

<?php

const ATTRIBUTES = ['Heads' => 0, 'Legs' => 1, 'Eyes' => 2, 'Wings' => 3, 'Horns' => 4];
const TYPES = [
    "Rabbits" => [1, 4, 2, 0, 0],
    "Chickens" => [1, 2, 2, 2, 0],
    "Cows" => [1, 4, 2, 0, 2],
    "Pegasi" => [1, 4, 2, 2, 0],
    "Demons" => [1, 4, 4, 2, 4],
];

function solve(array $species, array $counts, array $attributes) {
    global $goal;

    if(!$species) {
        foreach($goal as $id => $count) {
            if($attributes[$id] != $count) return null;
        }

        return $counts;
    }

    $specie = array_shift($species);
    $count = 1;

    while(true) {
        $attributes2 = $attributes;

        for($i = 0; $i < 5; ++$i) {
            $attributes2[$i] += $count * TYPES[$specie][$i]; 
            if(isset($goal[$i]) && $attributes2[$i] > $goal[$i]) return null;
        }

        if(($result = solve($species, $counts + [$specie => $count], $attributes2)) !== null) break;

        ++$count;
    }

    return $result;
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
$species = explode(" ", trim(fgets(STDIN)));

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d", $thing, $number);

    $goal[ATTRIBUTES[$thing]] = $number;
}

error_log(var_export($goal, 1));

foreach(solve($species, [], [0, 0, 0, 0, 0]) as $specie => $count) echo "$specie $count" . PHP_EOL;

error_log(microtime(1) - $start);

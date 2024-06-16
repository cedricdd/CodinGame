<?php

const TIMES = [
    'B' => ['A' => 40, 'G' => 30, 'L' => 50],
    'A' => ['B' => 40, 'N' => 70, 'L' => 70],
    'G' => ['B' => 30, 'Br' => 20],
    'L' => ['B' => 50, 'A' => 70],
    'N' => ['A' => 70, 'M' => 30],
    'Br' => ['G' => 20, 'Lv' => 20],
    'Lv' => ['Br' => 20],
    'M' => ['N' => 30],
    'T' => ['C' => 75],
    'C' => ['T' => 75],
];

function solve(string $city1, int $time = 0, array $visited = []) {
    global $solution, $city2;

    if($time >= $solution) return; //We already have a fastest route
    if($city1 == $city2) { //We reached the destination
        $solution = $time;
        return;
    }

    if(isset($visited[$city1])) return; //We have already been here
    else $visited[$city1] = 1;

    foreach(TIMES[$city1] as $city3 => $travel) {
        solve($city3, $time + $travel, $visited);
    }
}

fscanf(STDIN, "%s", $city1);
fscanf(STDIN, "%s", $city2);

$solution = INF;

solve($city1, 0);

echo ($solution == INF ? "-1" : $solution) . PHP_EOL;

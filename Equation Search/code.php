<?php

const POSSIBILITIES = [
    4  => [[1, 3, '+'], [2, 2, '+'], [1, 4, 'x'], [2, 2, 'x']],
    5  => [[1, 4, '+'], [2, 3, '+'], [1, 5, 'x']],
    6  => [[1, 5, '+'], [2, 4, '+'], [3, 3, '+'], [1, 6, 'x'], [2, 3, 'x']],
    7  => [[1, 6, '+'], [2, 5, '+'], [3, 4, '+'], [1, 7, 'x']],
    8  => [[1, 7, '+'], [2, 6, '+'], [3, 5, '+'], [4, 4, '+'], [1, 8, 'x'], [2, 4, 'x']],
    9  => [[1, 8, '+'], [2, 7, '+'], [3, 6, '+'], [4, 5, '+'], [1, 9, 'x'], [3, 3, 'x']],
    10 => [[1, 9, '+'], [2, 8, '+'], [3, 7, '+'], [4, 6, '+'], [5, 5, '+'], [2, 5, 'x']],
    11 => [[2, 9, '+'], [3, 8, '+'], [4, 7, '+'], [5, 6, '+']],
    12 => [[3, 9, '+'], [4, 8, '+'], [5, 7, '+'], [6, 6, '+'], [2, 6, 'x'], [3, 4, 'x']],
    13 => [[4, 9, '+'], [5, 8, '+'], [6, 7, '+']],
    14 => [[5, 9, '+'], [6, 8, '+'], [7, 7, '+'], [2, 7, 'x']],
    15 => [[6, 9, '+'], [7, 8, '+'], [3, 5, 'x']],
    16 => [[7, 9, '+'], [8, 8, '+'], [2, 8, 'x'], [4, 4, 'x']],
    17 => [[8, 9, '+']],
    18 => [[9, 9, '+'], [2, 9, 'x'], [3, 6, 'x']],
    20 => [[4, 5, 'x']],
    21 => [[3, 7, 'x']],
    24 => [[3, 8, 'x'], [4, 6, 'x']],
    25 => [[5, 5, 'x']],
    27 => [[3, 9, 'x']],
    28 => [[4, 7, 'x']],
];

function solve(array $digits, int $index, array $equations): int {
    global $results, $right, $nbrEquations;

    static $history = [];

    $hash = serialize($digits);

    if(isset($history[$hash][$index])) return $history[$hash][$index];

    //We have created all the equations
    if($index == $nbrEquations) {
        $results = $equations; //We only want to display it if there's only 1 set, we don't of overwritting in other cases

        return 1;
    }

    $goal = $right[$index];
    $total = 0;

    //Check all the ways to reach the goal
    foreach(POSSIBILITIES[$goal] as [$d1, $d2, $sign]) {
        if(!isset($digits[$d1]) || !isset($digits[$d2])) continue; //We need one of both

        $digits2 = $digits;
        
        if($digits2[$d1] == 1) unset($digits2[$d1]);
        else $digits2[$d1]--;

        //If d1 == d2 we might not have another one left
        if(isset($digits2[$d2])) {
            if($digits2[$d2] == 1) unset($digits2[$d2]);
            else $digits2[$d2]--;

            $total += solve($digits2, $index + 1, $equations + [$index => "$d1 $sign $d2 = $goal"]);
        }
    }

    return $history[$hash][$index] = $total;
}

$start = microtime(1);

fscanf(STDIN, "%d", $nbrEquations);
$right = explode(" ", trim(fgets(STDIN)));

foreach(explode(" ", trim(fgets(STDIN))) as $i => $v) {
    if($v > 0) $digits[$i + 1] = $v;
}

$results = [];

$count = solve($digits, 0, []);

echo $count . PHP_EOL;

if($count == 1) echo implode(PHP_EOL, $results) . PHP_EOL;

error_log(microtime(1) - $start);

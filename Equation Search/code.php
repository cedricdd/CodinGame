<?php

function solve(array $digits, int $index, array $equations): int {
    global $results, $right, $nbrEquations;

    static $history = [];

    $hash = serialize($digits);

    if(isset($history[$hash][$index])) return $history[$hash][$index];

    if($index == $nbrEquations) {
        $results = $equations;

        return 1;
    }

    $goal = $right[$index];
    $total = 0;

    // error_log("working on $goal -- $index");

    foreach($digits as $d => $c) {
        $diff = $goal - $d;

        $digits2 = $digits;

        if($digits2[$d] == 1) unset($digits2[$d]);
        else $digits2[$d]--;

        if($diff >= $d && isset($digits2[$diff])) {
            if($digits2[$diff] == 1) unset($digits2[$diff]);
            else $digits2[$diff]--;

            $total += solve($digits2, $index + 1, $equations + [$index => "$d + $diff = $goal"]);
        }

        if($goal % $d == 0) {
            $div = $goal / $d;

            $digits2 = $digits;

            if($digits2[$d] == 1) unset($digits2[$d]);
            else $digits2[$d]--;

            if($div >= $d && isset($digits2[$div])) {
                if($digits2[$div] == 1) unset($digits2[$div]);
                else $digits2[$div]--;
    
                $total += solve($digits2, $index + 1, $equations + [$index => "$d x $div = $goal"]);
            }
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

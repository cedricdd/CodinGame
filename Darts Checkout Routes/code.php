<?php

const SINGLE = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 25];
const DOUBLE = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 40, 50];
const TREBLE = [3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36, 39, 42, 45, 48, 51, 54, 57, 60];

function solve(int $score, int $darts): int {
    static $history = [];

    if(isset($history[$score][$darts])) return $history[$score][$darts]; //We already know the result

    if($darts == 0) return 0; //No darts left

    $possibilities = 0;

    //We are only forced to use a double with the last dart
    if($darts > 1) {
        foreach(SINGLE as $value) {
            if($value > $score - 2) break;

            $possibilities += solve($score - $value, $darts - 1);
        }
    
        foreach(TREBLE as $value) {
            if($value > $score - 2) break;
    
            $possibilities += solve($score - $value, $darts - 1);
        }
    }

    foreach(DOUBLE as $value) {
        if($value > $score) break;

        if($value == $score) $possibilities += 1; //We have found a solution to reach the score
        else $possibilities += solve($score - $value, $darts - 1);
    }

    return $history[$score][$darts] = $possibilities;
}

$start = microtime(1);

fscanf(STDIN, "%d", $score);
fscanf(STDIN, "%d", $darts);

echo solve($score, $darts) . PHP_EOL;

error_log(microtime(1) - $start);

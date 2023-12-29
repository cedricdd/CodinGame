<?php

fscanf(STDIN, "%d %d %d", $n, $a, $b);

$s = microtime(1);

$score = 0;
$start = 0;
$end = 0;
$first = [];

foreach(explode(" ", trim(fgets(STDIN))) as $i => $temp) {
    $score += ($temp >= $a && $temp <= $b) ? 1 : -1;

    //If the score is positive at any single time it means that every days from the start up to the current day is part of the best solution
    if($score > 0) {
        $start = 0;
        $end = $i;
    }
    else {
        //If this is the first time we reach this score we save it
        if(!isset($first[$score])) $first[$score] = $i;

        //If previously we had reached (score - 1) we know that the interval between the day we were at (score - 1) and the current day is positive,
        //we check if this interval is bigger than our current best one.
        if(isset($first[$score - 1]) && ($i - $first[$score - 1]) > ($end - $start)) {
            $end = $i;
            $start = $first[$score - 1] + 1; //We can't use the day saved, all the day saved are bad days, if we use it the interval will have a sum of 0
        }
    }
}

echo ($start + 1) . " " . ($end + 1) . PHP_EOL;

error_log(microtime(1) - $s);

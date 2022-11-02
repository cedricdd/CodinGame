<?php

$N = explode(",", trim(fgets(STDIN), "[]"));

sort($N); //sorted from lowest to highest
$ans = [];
$range = [];

for($i = 0; $i <= count($N); ++$i) {

    $number = $N[$i] ?? 0; //We do it one more time than the # of numbers, use a filler value for the extra time

    //Add the number to the current range
    if(count($range) == 0 || $number == end($range) + 1) $range[] = $number;
    else {
        //Range is broken add it to the answer
        if(count($range) >= 3) $ans[] = reset($range) . "-" . end($range);
        else $ans = array_merge($ans, $range);

        //Start a new range
        $range = [$number];
    }
}

echo implode(",", $ans) . PHP_EOL;

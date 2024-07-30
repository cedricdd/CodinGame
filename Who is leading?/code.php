<?php

const MAX_TIME = 81; 
const POINTS = [5, 2, 3, 3];

$teams = explode(",", trim(fgets(STDIN)));
$info1 = array_map(function($info) {
    return array_filter(explode(" ", $info));
}, explode(",", trim(fgets(STDIN))));
$info2 = array_map(function($info) {
    return array_filter(explode(" ", $info));
}, explode(",", trim(fgets(STDIN))));

$prev = 0;
$scores = [1 => [0, 0], 2 => [0, 0]];


while(true) {
    $next = [MAX_TIME, null, null];

    //Find the next points to add
    for($i = 0; $i < 4; ++$i) {
        for($player = 1; $player <= 2; ++$player) {
            $time = count(${'info' . $player}[$i]) ? reset(${'info' . $player}[$i]) : MAX_TIME;

            if($time < $next[0]) {
                $next = [$time, $player, $i];
            } 
        }
    }

    //If one team was leading, increase the duration
    if($scores[1][0] > $scores[2][0]) $scores[1][1] += $next[0] - $prev;
    elseif($scores[1][0] < $scores[2][0]) $scores[2][1] += $next[0] - $prev;

    if($next[0] == MAX_TIME) break; //Game is over

    $scores[$next[1]][0] += POINTS[$next[2]]; //Add the points

    $prev = $next[0];

    array_shift(${'info' . $next[1]}[$next[2]]);
}

echo $teams[0] . ': ' . implode(" ", $scores[1]) . PHP_EOL;
echo $teams[1] . ': ' . implode(" ", $scores[2]) . PHP_EOL;

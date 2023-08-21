<?php

const DIRECTION = [[1, 0], [0, 1], [-1, 0], [0, -1]];

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%s %s", $vp, $hp);
fscanf(STDIN, "%s %s", $order, $d);

$spiral = array_fill(0, $n, array_fill(0, $n, 0));

//The starting point and the starting direction
if($vp == "t" && $hp == "l") {
    $x = 0;
    $y = 0;
    $direction = 0;
} elseif($vp == "t" && $hp == "r") {
    $x = $n - 1;
    $y = 0;
    $direction = 1;
} elseif($vp == "b" && $hp == "r") {
    $x = $n - 1;
    $y = $n - 1;
    $direction = 2;
} elseif($vp == "b" && $hp == "l") {
    $x = 0;
    $y = $n - 1;
    $direction = 3;
}

//We are going counter-clockwise
if($d != "c") $direction = ($direction + 1) % 4;

$numbers = ($order == "+") ? range($n ** 2, 1) : range(1, $n ** 2);

while(true) {
    $spiral[$y][$x] = array_pop($numbers);

    if(count($numbers) == 0) break;

    //If we are leaving the spiral or reaching and already set number we need to change direction
    if(($spiral[$y + DIRECTION[$direction][1]][$x + DIRECTION[$direction][0]] ?? "1") != 0) {
        $direction = ($direction + ($d == "c" ? 1 : -1) + 4) % 4;
    }

    $x += DIRECTION[$direction][0];
    $y += DIRECTION[$direction][1];
}

echo implode("\n", array_map(function($line) {
    return implode("\t", $line);
}, $spiral)) . PHP_EOL;

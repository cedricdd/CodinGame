<?php

const DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]];

$direction = 0;
$drawing = 1;
$symbol = "#";
$x = 0;
$y = 0;
$default = " ";
$grid = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    foreach(explode(";", trim(fgets(STDIN))) as $cmd) {

        if(strcasecmp($cmd, "PU") == 0) $drawing = 0; //PENUP
        elseif(strcasecmp($cmd, "PD") == 0) $drawing = 1; //PENDOWN
        else {
            [$cmd, $info] = explode(" ", $cmd);

            //Turning Right
            if(strcasecmp($cmd, "RT") == 0) $direction = ($direction + intdiv($info, 90)) % 4;
            //Turning Left
            elseif(strcasecmp($cmd, "LT") == 0) $direction = ($direction - intdiv($info, 90) + 4) % 4;
            //Change writting symbol
            elseif(strcasecmp($cmd, "SETPC") == 0) $symbol = $info;
            //Change default symbol
            elseif(strcasecmp($cmd, "CS") == 0) $default = $info;
            //Turtle is moving
            elseif(strcasecmp($cmd, "FD") == 0) {
                for($t = 0; $t < $info; ++$t) {
                    if($drawing == 1) $grid[$y][$x] = $symbol;
                    $x += DIRECTIONS[$direction][0];
                    $y += DIRECTIONS[$direction][1];
                }
            }
        }
    }
}

$min = INF;
$max = -INF;

//We need to know the width of the output
foreach($grid as $y => $line) {
    $keys = array_keys($line);

    $min = min(min($keys), $min);
    $max = max(max($keys), $max);
}

ksort($grid);

foreach($grid as $y => $line) {
    $answer = str_repeat($default, $max - $min);

    foreach($line as $x => $c) $answer[$x - $min] = $c;

    echo rtrim($answer) . PHP_EOL;
}

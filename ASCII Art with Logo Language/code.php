<?php

const DIRECTIONS = [[0, -1], [1, 0], [0, 1], [-1, 0]];

$direction = 0;
$drawing = 1;
$symbol = "#";
$x = 0;
$y = 0;
$background = " ";
$grid = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    foreach(explode(";", trim(fgets(STDIN))) as $cmd) {
        
        if(strcasecmp($cmd, "PU") == 0) $drawing = 0; //PENUP
        elseif(strcasecmp($cmd, "PD") == 0) $drawing = 1; //PENDOWN
        else {
            [$cmd, $info] = explode(" ", $cmd);

            if(strcasecmp($cmd, "RT") == 0) $direction = ($direction + intdiv($info, 90)) % 4; //Turning right
            elseif(strcasecmp($cmd, "LT") == 0) $direction = ($direction - intdiv($info, 90) + 4) % 4; //Turning left
            elseif(strcasecmp($cmd, "SETPC") == 0) $symbol = $info; //Changes the symbols printed
            elseif(strcasecmp($cmd, "CS") == 0) $background = $info; //Changes the background character
            //Turtle is moving
            elseif(strcasecmp($cmd, "FD") == 0) {
                for($t = 0; $t < $info; ++$t) {
                    if($drawing == 1) $grid[$y][$x] = $symbol; //The pen is down we are adding symbols
                    $x += DIRECTIONS[$direction][0];
                    $y += DIRECTIONS[$direction][1];
                }
            }
        }
    }
}

//We need the coordinates of the top left & bottom right of the art generated
$minY = min(array_keys($grid));
$maxY = max(array_keys($grid));
$minX = INF;
$maxX = -INF;

foreach($grid as $y => $line) {
    $minX = min(min(array_keys($line)), $minX);
    $maxX = max(max(array_keys($line)), $maxX);
}

$width = $maxX - $minX + 1;

for($y = $minY; $y <= $maxY; ++$y) {
    $answer = str_repeat($background, $width);

    foreach($grid[$y] ?? [] as $x => $c) $answer[$x - $minX] = $c;

    echo rtrim($answer) . PHP_EOL;
}

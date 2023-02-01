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
        
        if(strcasecmp($cmd, "PU") == 0) $drawing = 0;
        elseif(strcasecmp($cmd, "PD") == 0) $drawing = 1;
        else {
            [$cmd, $info] = explode(" ", $cmd);

            if(strcasecmp($cmd, "RT") == 0) $direction = ($direction + intdiv($info, 90)) % 4;
            elseif(strcasecmp($cmd, "LT") == 0) $direction = ($direction - intdiv($info, 90) + 4) % 4;
            elseif(strcasecmp($cmd, "SETPC") == 0) $symbol = $info;
            elseif(strcasecmp($cmd, "CS") == 0) $default = $info;
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

$minY = min(array_keys($grid));
$maxY = max(array_keys($grid));
$minX = INF;
$maxX = -INF;

foreach($grid as $y => $line) {
    $keys = array_keys($line);

    $minX = min(min($keys), $minX);
    $maxX = max(max($keys), $maxX);
}

for($y = $minY; $y <= $maxY; ++$y) {
    $answer = str_repeat($default, $maxX - $minX);

    foreach($grid[$y] ?? [] as $x => $c) $answer[$x - $minX] = $c;

    echo rtrim($answer) . PHP_EOL;
}

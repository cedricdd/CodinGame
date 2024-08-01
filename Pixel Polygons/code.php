<?php

const CHECK = [[1, 0, 1, -1], [0, 1, 1, 1], [-1, 0, -1, 1], [0, -1, -1, -1]];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $map[] = trim(fgets(STDIN));
}

error_log(var_export($map, true));

//Find the first # starting at top left
$position = strpos(implode("", $map), '#');

[$x, $y] = [$position % $N, intdiv($position, $N)];

error_log("$x $y");

$d = 0;
$sides = 0;
$history = [];

while(true) {
    if(isset($history["$x $y $d"])) break;
    else $history["$x $y $d"] = 1;

    [$x1, $y1, $x2, $y2] = CHECK[$d];

    while($map[$y + $y1][$x + $x1] == '#' && $map[$y + $y2][$x + $x2] == '.') {
        $x += $x1;
        $y += $y1;
    }

    ++$sides;
    $d = ($d + 1) % 4;
    error_log("$x $y $d");
}

echo $sides . PHP_EOL;

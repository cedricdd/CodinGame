<?php

const MOVES = ["north" => [0, -1], "south" => [0, 1], "west" => [-1, 0], "east" => [1, 0]];

fscanf(STDIN, "%d %d %d", $w, $h, $n);
for ($y = 0; $y < $h; ++$y) {
    $line = trim(fgets(STDIN));

    foreach(str_split($line) as $x => $c) {
        if($c === ".") {
            $positions[] = [$x, $y];
        }
    }

    $map[] = $line;
}
for ($i = 0; $i < $n; $i++) {
    $updatedPositions = [];

    preg_match("/(south|north|east|west)/i", trim(fgets(STDIN)), $matches);

    error_log(var_export($matches, true));

    $direction = strtolower($matches[1]);

    foreach($positions as [$x, $y]) {
        $xm = $x + MOVES[$direction][0];
        $ym = $y + MOVES[$direction][1];

        if($xm >= 0 && $xm < $w && $ym >= 0 && $ym <$h && $map[$ym][$xm] !== "o") $updatedPositions[] = [$xm, $ym];
    }

    $positions = $updatedPositions;
}

foreach($positions as [$x, $y]) $map[$y][$x] = "X";

echo count($positions) . PHP_EOL . implode("\n", $map) . PHP_EOL;

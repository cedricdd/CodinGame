<?php

$color = trim(fgets(STDIN));
for ($y = 0; $y < 8; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == "Q") {
            $xQ = $x;
            $yQ = $y;
        }

        $board[$y][$x] = $c;
    }
}

$count = 0;
$directions = [[0, 1], [0, -1], [1, 0], [-1, 0], [-1, -1], [-1, 1], [1, -1], [1, 1]];

for($i = 1; $i < 8; ++$i) {
    foreach($directions as $index => [$xm, $ym]) {
        $xu = $xQ + $i * $xm;
        $yu = $yQ + $i * $ym;

        //We are out of the board in this direction
        if($xu < 0 || $xu > 7 || $yu < 0 || $yu > 7) {
            unset($directions[$index]);
            continue;
        }

        //We reach another piece, can't go any further in this direction
        if($board[$yu][$xu] != ".") {
            $count += $board[$yu][$xu] != $color[0];
            unset($directions[$index]);
            continue;
        }

        ++$count;
    }
}

echo $count . PHP_EOL;

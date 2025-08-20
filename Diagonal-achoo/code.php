<?php

const DIRECTIONS = [[-1, -1], [1, -1], [-1, 1], [1, 1]];

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $g);

$bestIndex = null;
$bestCount = 0;
$bestGrid = [];

for ($i = 0; $i < $g; $i++) {
    $grid = [];
    $queue = [];
    $count = 0;

    for ($y = 0; $y < $n; ++$y) {
        $grid[$y] = "";

        foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
            if($c == 'C') $queue[] = [$x, $y, true];

            $grid[$y] .= $c;
        }
    }

    while($queue) {
        [$x, $y, $init] = array_pop($queue);

        if($grid[$y][$x] != '.' && $init == false) continue;
        else $grid[$y][$x] = 'C';

        ++$count;

        foreach(DIRECTIONS as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < $n && $yu >= 0 && $yu < $n && $grid[$yu][$xu] == '.') $queue[] = [$xu, $yu, false];
        }
    }

    if($count > $bestCount) {
        $bestIndex = $i;
        $bestCount = $count;
        $bestGrid = $grid;
    }
}

echo $bestIndex . PHP_EOL . implode(PHP_EOL, $bestGrid) . PHP_EOL;

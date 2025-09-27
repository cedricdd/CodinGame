<?php

function getEnergy(array $image, int $x, int $y): int {
    global $W, $H;

    $dIdx = ($x > 0 && $x < $W - 1) ? ($image[$y][$x + 1] - $image[$y][$x - 1]) : 0;
    $dIdy = ($y > 0 && $y < $H - 1) ? ($image[$y + 1][$x] - $image[$y - 1][$x]) : 0;
    return abs($dIdx) + abs($dIdy);
}

function generateEnergy(array $image): array {
    global $W, $H;

    $energy = [];

    for($y = 0; $y < $H; ++$y) {
        for($x = 0; $x < $W; ++$x) {
            $energy[$y][$x] = getEnergy($image, $x, $y);
        }

        // error_log(implode(" ", array_map(function($v) {
        //     return str_pad($v, 3, '0', STR_PAD_LEFT);
        // }, $energy[$y])));
    }

    return $energy;
}

function generatePath(array $energy): array {
    global $W, $H;

    $paths = [];

    for($x = 0; $x < $W; ++$x) {
        $paths[0][$x] = [$energy[0][$x], null];
    }

    for($y = 1; $y < $H; ++$y) {
        for($x = 0; $x < $W; ++$x) {
            $best = [INF, ""];

            //Find the best way to reach this position
            for($i = -1; $i <= 1; ++$i) {
                if($x + $i >= 0 && $x + $i < $W && $paths[$y - 1][$x + $i][0] < $best[0]) $best = [$paths[$y - 1][$x + $i][0], $i];
            }

            $paths[$y][$x] = [$energy[$y][$x] + $best[0], $best[1]];
        }
    }

    return $paths;
}

$start = microtime(1);

$magic = stream_get_line(STDIN, 3 + 1, "\n");
fscanf(STDIN, "%d %d", $W, $H);
fscanf(STDIN, "%s %d", $comment, $V);
fscanf(STDIN, "%d", $maxintensity);

for ($i = 0; $i < $H; $i++) {
    $image[] = array_map('intval', explode(" ", trim(fgets(STDIN))));
}

while(true) {
    $energy = generateEnergy($image);
    $paths = generatePath($energy);

    $bestPath = [INF, null];

    foreach($paths[$H - 1] as $x => [$sum, ]) {
        if($sum < $bestPath[0]) $bestPath = [$sum, $x];
    }

    echo $bestPath[0] . PHP_EOL;

    --$W;

    if($W == $V) break;

    //Remove the path with the lowest energy
    $x = $bestPath[1];
    $y = $H - 1;

    while(true) {
        array_splice($image[$y], $x, 1);
        array_splice($energy[$y], $x, 1);

        if($paths[$y][$x][1] === null) break;

        $x += $paths[$y][$x][1];
        $y--;
    }
}

error_log(microtime(1) - $start);

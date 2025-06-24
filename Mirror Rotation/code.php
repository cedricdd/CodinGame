<?php

const MOVES = ['N' => [0, -1], 'S' => [0, 1], 'E' => [1, 0], 'W' => [-1, 0]];

function explore(int $x, int $y, string $dir, array $flips = []): void {
    global $room, $bestCount, $bestFlips;

    while(true) {
        $x += MOVES[$dir][0];
        $y += MOVES[$dir][1];

        if($room[$y][$x] == 'T') {
            $bestCount = count($flips);
            $bestFlips = $flips;

            break;
        }

        if($room[$y][$x] == '#') break;

        if($room[$y][$x] == '\\') {
            
        }
    }
}

fscanf(STDIN, "%d %d", $w, $h);

for ($y = 0; $y < $w; ++$y) {
    $line = trim(fgets(STDIN));

    if(($x = strpos($line, 'L')) !== false) {
        $xs = $x;
        $ys = $y;
    }

    $room[] = $line;
}

fscanf(STDIN, "%s", $dir);

$bestCount = INF;
$bestFlips = [];

explore($xs, $ys, $dir);

echo $bestCount . PHP_EOL;

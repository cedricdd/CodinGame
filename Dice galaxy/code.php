<?php

const MOVES = [[0, -1], [1, 0], [0, 1], [-1, 0]];
const PATHS = [[0, 0], [0, 1, 0], [0, 3, 0], [0, 1, 1, 0], [0, 3, 3, 0], [0, 1, 1, 1, 0], [0, 3, 3, 3, 0]];

fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $H);

for ($i = 0; $i < $H; ++$i) $map[] = str_split(str_replace("6", "#", trim(fgets(STDIN))));

for ($y = 0; $y < $H; ++$y) {
    foreach($map[$y] as $x => $c) {
        if($c == "1") {
            //We test all the paths to the "6" with the 4 orientations (ie: we change the starting position in the MOVES array)
            for($i = 0; $i < 4; ++$i) {
                foreach(PATHS as $index => $path) {
                    $x2 = $x;
                    $y2 = $y;

                    foreach($path as $move) {
                        $x2 += MOVES[($i + $move) % 4][0];
                        $y2 += MOVES[($i + $move) % 4][1];

                        if(($map[$y2][$x2] ?? ".") != "#") continue 2;
                    }

                    $map[$y2][$x2] = "6";
                    continue 3;
                }
            }
        }
    }
}

echo implode("\n", array_map(function ($line) {
    return implode("", $line);
}, $map)) . PHP_EOL;

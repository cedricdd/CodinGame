<?php

const MOVES = ['R' => [1, 0], 'L' => [-1, 0], 'D' => [0, 1], 'U' => [0, -1]];

fscanf(STDIN, "%d", $height);

fscanf(STDIN, "%d", $width);
for ($i = 0; $i < $height; $i++) {
    $map[] = stream_get_line(STDIN, 100 + 1, "\n");
}

$shortest = INF;
$mapShortest = [];

for($y = 0; $y < $height; ++$y) {
    if($map[$y][0]  != "#") {
        $x2 = 0;
        $y2 = $y;
        $direction  = 'R';
        $length = -1;
        $map2 = $map;

        while(true) {
            //Move until we reach a wall
            while(true) {
                ++$length;
                $map2[$y2][$x2] = '*';

                //We reached the throne room entrance
                if($x2 == $width - 1) {
                    if($length < $shortest) {
                        $shortest = $length;

                        $mapShortest = $map2;
                    }

                    break 2;
                }

                $xu = $x2 + MOVES[$direction][0];
                $yu = $y2 + MOVES[$direction][1];

                if(($map[$yu][$xu] ?? '#') == "#") break;
                else [$x2, $y2] = [$xu, $yu];
            }

            if($direction == 'L' || $direction == 'R') {
                //We can move down
                if(($map[$y2 - 1][$x2] ?? '#') == '#' && ($map[$y2 + 1][$x2] ?? '#') != '#') {
                    $direction = 'D';
                    ++$y2;
                }
                //We can move up
                elseif(($map[$y2 + 1][$x2] ?? '#') == '#' && ($map[$y2 - 1][$x2] ?? '#') != '#') {
                    $direction = 'U';
                    --$y2;
                }
                //Dead end
                else break;
            } else {
                //We can move left
                if(($map[$y2][$x2 + 1] ?? '#') == '#' && ($map[$y2][$x2 - 1] ?? '#') != '#') {
                    $direction = 'L';
                    --$x2;
                }
                //We can move right
                elseif(($map[$y2][$x2 - 1] ?? '#') == '#' && ($map[$y2][$x2 + 1] ?? '#') != '#') {
                    $direction = 'R';
                    ++$x2;
                }
                //Dead end
                else break;
            }
        }
    }
}

if($shortest == INF) echo "0" . PHP_EOL;
else echo $shortest . PHP_EOL . implode("\n", $mapShortest) . PHP_EOL;

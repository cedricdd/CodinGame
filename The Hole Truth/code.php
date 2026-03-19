<?php

fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++) {
    $grid[$i] = stream_get_line(STDIN, 100 + 1, "\n");
}

$totalHoles = 0;

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        if($grid[$y][$x] == '.') {
            $queue = [[$x, $y]];
            $hole = true;

            while($queue) {
                [$x2, $y2] = array_pop($queue);

                //We have reached the border, it's not considered as a hole
                if($x2 < 0 || $x2 >= $W || $y2 < 0 || $y2 >= $H) {
                    $hole = false;
                    continue;
                }

                if($grid[$y2][$x2] != '.') continue; //This position is already solid

                $grid[$y2][$x2] = '#';

                foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) $queue[] = [$x2 + $xm, $y2 + $ym]; //We can move in 4 directions
            }

            $totalHoles += $hole ? 1 : 0;
        }
    }
}

echo $totalHoles . PHP_EOL;

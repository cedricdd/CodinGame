<?php

fscanf(STDIN, "%d %d", $h, $w);
for ($i = 0; $i < $h; $i++) {
    $grid[] = trim(fgets(STDIN));
}

$total = 0;

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($grid[$y][$x] == '*') {
            ++$total;
            $queue = [[$x, $y]];

            while($queue) {
                [$x, $y] = array_pop($queue);

                $grid[$y][$x] = '.';

                foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                    $xu = $x + $xm;
                    $yu = $y + $ym;

                    if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h && $grid[$yu][$xu] == '*') $queue[] = [$xu, $yu];
                }
            }
        }
    }
}

echo $total . PHP_EOL;
echo $total . PHP_EOL;

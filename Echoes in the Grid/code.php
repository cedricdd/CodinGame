<?php

$alphabet = array_flip(range('A', 'Z'));

fscanf(STDIN, "%d %d", $H, $W);
fscanf(STDIN, "%f %f", $DECAY, $THRESHOLD);

for ($i = 0; $i < $H; $i++) {
    fscanf(STDIN, "%s", $grid[]);
}

$weights = array_fill(0, $H, array_fill(0, $W, 0));

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        //There's a signal here
        if(ctype_alpha($grid[$y][$x])) {
            $power = $alphabet[$grid[$y][$x]] + 1;
            $weights[$y][$x] += $power;

            //Propagate the signal
            foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                $xp = $x;
                $yp = $y;
                $p = $power;

                while(1) {
                    $xp += $xm;
                    $yp += $ym;
                    $p *= $DECAY;

                    if($xp < 0 || $xp >= $W || $yp < 0 || $yp >= $H || $grid[$yp][$xp] == '#') break;

                    $weights[$yp][$xp] += $p;
                }
            }
        }
    }
}

$total = 0;

foreach($weights as $line) {
    $total += count(array_filter($line, function($value) use ($THRESHOLD) {
        return $value >= $THRESHOLD;
    }));
}

echo $total . PHP_EOL;

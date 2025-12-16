<?php

fscanf(STDIN, "%d", $nbSteps);
fscanf(STDIN, "%d %d", $h, $w);
for ($i = 0; $i < $h; $i++) {
    $image[] = stream_get_line(STDIN, 1024 + 1, "\n");
}

$queue = [];

//Find all the points that will get deleting in the first step
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($image[$y][$x] == '#') {
            foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu < 0 || $xu >= $w || $yu < 0 || $yu >= $h || $image[$yu][$xu] != '#') {
                    $queue[1][] = [$x, $y];

                    continue 2;
                }
            }
        }
    }
}

for($i = 1; $i <= $nbSteps; ++$i) {
    if(!isset($queue[$i])) break; //There is nothing left to erase

    foreach($queue[$i] as [$x, $y]) {
        if($image[$y][$x] != '#') continue; //This point was already removed

        $image[$y][$x] = '.';

        //All the neighbors (if still present) will get remove at next turn
        foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h && $image[$yu][$xu] == '#') $queue[$i + 1][] = [$xu, $yu]; 
        }
    }

    unset($queue[$i]);
}

echo implode(PHP_EOL, $image) . PHP_EOL;

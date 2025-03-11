<?php

fscanf(STDIN, "%d", $N);

$line = array_fill(0, $N, 1);
$grid = array_fill(0, $N, $line);

for ($y = 0; $y < $N; $y++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if(ctype_digit($c)) {
            for($y2 = $y - $c - 1; $y2 <= $y + $c + 1; ++$y2) {
                for($x2 = $x - $c - 1; $x2 <= $x + $c + 1; ++$x2) {
                    //It's a dangerous position for the hero
                    if((abs($x - $x2) + abs($y - $y2)) <= $c + 1) {
                        unset($grid[$y2][$x2]);
                    }
                }
            }
        } elseif($c == 'H') $hero = [$x, $y];
    }
}

$distanceSafe = PHP_INT_MAX;
$coordinate = "";

foreach($grid as $y => $line) {
    foreach($line as $x => $filler) {
        $distance = abs($hero[0] - $x) + abs($hero[1] - $y);

        if($distance < $distanceSafe) {
            $distanceSafe = $distance;
            $coordinate = "(" . $x . "," . $y . ")";
        }
    }
}

echo $coordinate . PHP_EOL;

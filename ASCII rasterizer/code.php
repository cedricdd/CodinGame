<?php

fscanf(STDIN, "%d %d", $N, $M);
fscanf(STDIN, "%f", $factor);
fscanf(STDIN, "%d", $K);

$screen = array_fill(0, $M, array_fill(0, $N, " "));
$zInfo = array_fill(0, $M, array_fill(0, $N, INF));

for ($i = 0; $i < $K; $i++) {
    fscanf(STDIN, "%f %f %f %f %s", $x, $y, $z, $r, $texture);

    //Update the radius with the factor
    $r = $r * (1 - $factor) ** $z;

    for($y2 = max(0, $y - floor($r)); $y2 <= min($M - 1, $y + floor($r)); ++$y2) {
        for($x2 = max(0, $x - floor($r)); $x2 <= min($N - 1, $x + floor($r)); ++$x2) {
            
            $distance = sqrt(($x - $x2) ** 2 + ($y - $y2) ** 2);
            $z2 = $z - sqrt($r ** 2 - ($x - $x2) ** 2 - ($y - $y2) ** 2);

            //The pixel is part of the sphere and not hidden by a previous sphere
            if($distance <= $r && $z2 < $zInfo[$y2][$x2]) {
                $screen[$y2][$x2] = $texture;
                $zInfo[$y2][$x2] = $z2;
            }
        }
    }
}

echo implode("\n", array_map("implode", array_reverse($screen))) . PHP_EOL;
